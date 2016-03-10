<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use ErrorException;
use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;
use App\Models\SubidaOsp;
use App\Models\Lote;
use App\Models\PUCO\Provincia as OspProvincias;
use App\Models\PUCO\Osp;
use App\Models\Geo\Provincia;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class PadronesController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
		setlocale(LC_TIME, 'es_ES.UTF-8');
	}

	/**
	 * Devuelve la vista principal
	 * @param string $padron
	 * @param int $id
	 * 
	 * @return null
	 */
	public function getMain($id){		

		$archivos_pendientes = Subida::where('id_estado' , 1)->where('id_padron' , $id)->where('id_usuario' , Auth::user()->id_usuario)->count();
		
		$lotes_pendientes = Lote::join('sistema.subidas' , 'sistema.lotes.id_subida' , '=' , 'sistema.subidas.id_subida')
							->where('id_padron' , $id)
							->where('sistema.lotes.id_estado' , 1);

		$lotes_no_declarados = DB::table('sistema.lotes as l')
			->join('sistema.subidas as s' , 'l.id_subida' , '=' , 's.id_subida')
			->join('sistema.lotes_aceptados as a' , 'l.lote' , '=' , 'a.lote')
			->where('s.id_padron' , $id)
			->whereNotIn('l.lote' , function($q){
					$q->select(DB::raw('unnest(lote)'))
					->from('ddjj.sirge');
				});
			

		if (Auth::user()->id_entidad == 2) {
			$lotes_pendientes = $lotes_pendientes->where('id_provincia' , Auth::user()->id_provincia)->count();
			$lotes_no_declarados = $lotes_no_declarados->where('id_provincia' , Auth::user()->id_provincia)->count();
		} else {
			$lotes_pendientes = $lotes_pendientes->count();
			$lotes_no_declarados = $lotes_no_declarados->count();
		}

		// return $lotes_pendientes;

		$data = [
			'page_title' => strtoupper($this->getName($id)),
			'id_padron' => $id,
			'archivos_pendientes' => $archivos_pendientes,
			'lotes_pendientes' => $lotes_pendientes,
			'lotes_no_declarados' => $lotes_no_declarados
		];
		return view('padrones.main' , $data);
	}

	/**
	 * Devuelve la ruta donde guardar el archivo
	 * @param int $id
	 *
	 * @return string
	 */
	protected function getName($id , $route = FALSE){			

		switch ($id) {
			case 1:
				$p = 'prestaciones'; break;
			case 2 :
				$p = 'fondos'; break;
			case 3 :
				$p = 'comprobantes'; break;
			case 4 : 
				$p = 'osp'; break;
			case 5 :
				$p = 'profe'; break;
			case 6 :
				$p = 'sss'; break;
			default:
				break;
		}
		if ($route)
			return '../storage/uploads/' . $p;
		else
			return ucwords($p);
	}

	/** 
	 * Devuelve la vista para subir un padrón
	 * @param int $id
	 *
	 * @return null
	 */
	public function getUpload($id){
		$data = [
			'page_title' => 'Subir archivos',
			'id_padron' => $id
		];

		if ($id == 4) {
			$osp = OspProvincias::where('codigo_osp' , '<' , 997001)->with('descripcion')->get();
			$data['obras'] = $osp;
		}
		return view('padrones.upload-files' , $data);
	}

	/**
	 * Guarda el archivo en el sistema
	 * @param $r Request
	 *
	 * @return json
	 */
	public function postUpload(Request $r){		

		$nombre_archivo = uniqid() . '.txt';

		$destino = $this->getName($r->id_padron , TRUE);
		$s = new Subida;

		$s->id_usuario = Auth::user()->id_usuario;
		$s->id_padron = $r->id_padron;
		$s->nombre_original = $r->file->getClientOriginalName();
		$s->nombre_actual = $nombre_archivo;
		$s->size = $r->file->getClientSize();
		$s->id_estado = 1;

		try {
			$r->file('file')->move($destino , $nombre_archivo);
		} catch (FileException $e){
			$s->delete();
			return response("Ha ocurrido un error: ". $e->getMessage() , 422);
		}
		if ($s->save()){
			switch ($r->id_padron) {
				case 4:
					if ($r->codigo_osp == 0){
						$s->delete();
						unlink($destino . '/' . $nombre_archivo);
						return response("Debe elegir la Obra Social a reportar" , 422);
					} else {
						$codigo_final = $r->codigo_osp;
						$id_archivo = 1;
						Osp::where('codigo_os' , $r->codigo_osp)->delete();
					}
					break;
				case 5:
					$id_archivo = 1;
					$codigo_final = 997001;
					break;
				case 6:
					if ($r->id_sss == 0){
						$s->delete();
						unlink($destino . '/' . $nombre_archivo);
						return response("Debe elegir el ID del archivo de la SSS" , 422);
					} else {
						$id_archivo = $r->id_sss;
						$codigo_final = 998001;
					}

					break;
			}

			if (isset($codigo_final)){
				$so = new SubidaOsp;
				$so->id_subida = $s->id_subida;
				$so->codigo_osp = $codigo_final;
				$so->id_archivo = $id_archivo;
				$so->save();
			}

			return response()->json(['file' => $r->file->getClientOriginalName()]); 
		}
	}

	/**
	 * Devuelve la vista para procesar archivos
	 *
	 * @return null
	 */
	public function listadoArchivos($id){
		$data = [
			'page_title' => 'Archivos subidos',
			'id_padron' => $id,
			'ruta_procesar' => 'procesar-' . strtolower($this->getName($id))
		];
		return view('padrones.process-files' , $data);
	}


	/**
	 * Devuelve el listado de archivos subidos
	 * @param int $id_padron
	 *
	 * @return json
	 */
	public function listadoArchivosTabla($id_padron){
		$archivos = Subida::where('id_padron' , $id_padron)
					->where('id_estado' , 1)
					->where('id_usuario' , Auth::user()->id_usuario)
					->get();
		return Datatables::of($archivos)
			->addColumn('action' , function($archivo){
              return '
              	<button id-subida="'. $archivo->id_subida .'" class="procesar btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Procesar</button>
              	<button id-subida="'. $archivo->id_subida .'" class="eliminar btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i> Eliminar</button>';
          	})
			->make(true);
	}

	/**
	 * Elimina un archivo
	 * @param int $id
	 *
	 * @return json
	 */
	public function eliminarArchivo($id){
		$f = Subida::find($id);
		$f->id_estado = 4;
		if ($f->save()){
			try {
				unlink ($this->getName($f->id_padron , TRUE) . '/' . $f->nombre_actual);
				return 'Se ha eliminado el archivo';
			} catch (ErrorException $e) {
				return 'Se ha eliminado el archivo';
			}
		}
	}

	/**
     * Devuelve listado de 6 meses 
     * @param int $meses
     *
     * @return array
     */
    protected function getMesesArray($meses){

        $dt = new \DateTime();
        $dt->modify("-$meses months");
        
        for ($i = 0 ; $i < $meses ; $i ++){
       		$dt->modify('+1 month');
            $array[$i] = ucwords(strftime("%b %y" , $dt->getTimeStamp()));
        }
        return $array;
    }

    /**
     * Inserta elementos en el array
     *
     * @return null
     */
    protected function insertDummy(){
    	
    	$fuentes = [
    		'prestaciones',
    		'comprobantes',
    		'fondos'
    	];

    	$provincias = [
    		'01','02','03','04','05','06',
    		'07','08','09','10','11','12',
    		'13','14','15','16','17','18',
    		'19','20','21','22','23','24',
    	];

    	for ($i = 0 ; $i < 6 ; $i ++){
	    	foreach ($fuentes as $fuente){
				foreach ($provincias as $provincia){
					$periodos[$provincia][$fuente][$i] = -1;
					$periodos[$provincia]['data'] = Provincia::find($provincia);
				}
	    	}
    	}

    	return $periodos;
    	
    }

	/**
	 * Devuelve la vista del consolidado
	 *
	 * @return null
	 */
	public function getConsolidado(){
	
		$consolidado = $this->insertDummy();

		$dt = new \DateTime();
		$dt->modify('-7 months');

		for ($i = 0 ; $i < 6 ; $i ++) {

			$dt->modify('+1 month');
			$dt->modify('first day of this month');
			$min = $dt->format('Y-m-d');
			$dt->modify('last day of this month');
			$max = $dt->format('Y-m-d');
			$dt->modify('first day of this month');
			
			$prestaciones = Lote::join('sistema.subidas as s' , 'sistema.lotes.id_subida' , '=' , 's.id_subida')
								->where('id_padron' , 1)
								->where('sistema.lotes.id_estado' , 3)
								->whereBetween('fin' , [$min , $max])
								->select('sistema.lotes.id_provincia' , DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo") , DB::raw('sum(registros_in) as c'))
								->groupBy(DB::raw('1'))
								->groupBy(DB::raw('2'))
								->orderBy(DB::raw('2'))
								->orderBy(DB::raw('1'))
								->get();

			foreach ($prestaciones as $prestacion){
				$consolidado[$prestacion->id_provincia]['prestaciones'][$i] = $prestacion->c;
			}

			$comprobantes = Lote::join('sistema.subidas as s' , 'sistema.lotes.id_subida' , '=' , 's.id_subida')
								->where('id_padron' , 3)
								->where('sistema.lotes.id_estado' , 3)
								->whereBetween('fin' , [$min , $max])
								->select('sistema.lotes.id_provincia' , DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo") , DB::raw('sum(registros_in) as c'))
								->groupBy(DB::raw('1'))
								->groupBy(DB::raw('2'))
								->orderBy(DB::raw('2'))
								->orderBy(DB::raw('1'))
								->get();

			foreach ($comprobantes as $comprobante){
				$consolidado[$comprobante->id_provincia]['comprobantes'][$i] = $comprobante->c;
			}

			$fondos = Lote::join('sistema.subidas as s' , 'sistema.lotes.id_subida' , '=' , 's.id_subida')
								->where('id_padron' , 2)
								->where('sistema.lotes.id_estado' , 3)
								->whereBetween('fin' , [$min , $max])
								->select('sistema.lotes.id_provincia' , DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo") , DB::raw('sum(registros_in) as c'))
								->groupBy(DB::raw('1'))
								->groupBy(DB::raw('2'))
								->orderBy(DB::raw('2'))
								->orderBy(DB::raw('1'))
								->get();

			foreach ($fondos as $fondo){
				$consolidado[$fondo->id_provincia]['fondos'][$i] = $fondo->c;
			}
		}

		$data = [
			'page_title' => 'Consolidado',
			'consolidado' => $consolidado,
			'meses' => $this->getMesesArray(6)
		];

		return view('padrones.consolidado' , $data);
	}

	/**
	 * Armar array vacio
	 *
	 * @return array
	 */
	protected function generarDummy($array){

		return array_fill_keys($array , 0);

	}

	/**
	 * Graficar la progresión de la fuente de datos
	 * @param int $padron
	 * @param string $provincia
	 *
	 * @return null
	 */
	public function graficarPadron($padron , $provincia){

		$meses = $this->getMesesArray(24);
		$aux = $this->generarDummy($meses);
		
		$dt = new \DateTime();
		$dt->modify('last day of this month');
		$max = $dt->format('Y-m-d');
		$dt->modify('first day of this month');
		$dt->modify("-24 months");
		$min = $dt->format('Y-m-d');

		$prestaciones = Lote::join('sistema.subidas as s' , 'sistema.lotes.id_subida' , '=' , 's.id_subida')
							->where('id_padron' , $padron)
							->where('sistema.lotes.id_estado' , 3)
							->where('sistema.lotes.id_provincia' , $provincia)
							->whereBetween('fin' , [$min , $max])
							->select('sistema.lotes.id_provincia' , DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo") , DB::raw('sum(registros_in) as c'))
							->groupBy(DB::raw('1'))
							->groupBy(DB::raw('2'))
							->orderBy(DB::raw('2'))
							->orderBy(DB::raw('1'))
							->get();

		foreach ($prestaciones as $prestacion){
			$dt = \DateTime::createFromFormat('Ym' , $prestacion->periodo);
			$pd = ucwords(strftime("%b %y" , $dt->getTimeStamp()));
			$aux[$pd] = $prestacion->c;
		}

		foreach ($aux as $a){
			$series[0]['name'] = 'Registros reportados';
			$series[0]['data'][] = $a;
		}

		$data = [
			'page_title' => 'Progresión reporte fuente de datos',
			'series' => json_encode($series),
			'categorias' => json_encode($meses)
		];

		return view('padrones.grafico-consolidado' , $data);

	}
}
