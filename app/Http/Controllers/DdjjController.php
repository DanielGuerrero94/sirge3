<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Datatables;
use PDF;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\DOIU9Request;
use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;
use App\Models\DDJJ\Sirge as DDJJSirge;
use App\Models\DDJJ\DOIU9 as D9;
use App\Models\DDJJ\Backup;
use App\Models\Efector;
use App\Models\Parametro;

class DdjjController extends Controller
{
	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * Devuelve la vista con los lotes a declarar
	 * @param int $padron
	 *
	 * @return null
	 */
	public function getListadoPendientes($padron){
		$pendientes = DB::table('sistema.lotes as l')
				->join('sistema.lotes_aceptados as a' , 'l.lote' , '=' , 'a.lote')
				->join('sistema.subidas as s' , 'l.id_subida' , '=' , 's.id_subida')
				->where('s.id_padron' , $padron)
				->whereNotIn('l.lote' , function($q){
					$q->select(DB::raw('unnest(lote)'))
					->from('ddjj.sirge');
				})
				->count();

		$data = [
			'page_title' => 'Declaración de lotes para DDJJ',
			'padron' => $padron,
			'pendientes' => $pendientes
		];
		return view('padrones.ddjj' , $data);
	}

	/**
	 * Devuelve el json para la datatable
	 * @param int $padron
	 *
	 * @return json
	 */
	public function getListadoPendientesTabla($padron){
		$lotes = DB::table('sistema.lotes as l')
				->join('sistema.lotes_aceptados as a' , 'l.lote' , '=' , 'a.lote')
				->join('sistema.subidas as s' , 'l.id_subida' , '=' , 's.id_subida')
				->where('s.id_padron' , $padron)
				->whereNotIn('l.lote' , function($q){
					$q->select(DB::raw('unnest(lote)'))
					->from('ddjj.sirge');
				})
				->select('l.*' , 'a.fecha_aceptado');

		return Datatables::of($lotes)
			->addColumn('fecha_format' , function($lote){
				return date_format(date_create($lote->fecha_aceptado) , 'd/m/Y');
			})->make(true);
	}

	/**
	 * Retorna la vista de las DDJJ por padrón
	 * @param int $id
	 *
	 * @return null
	 */
	public function getListado($id){
		$data = [
			'page_title' => 'Histórico de declaraciones juradas',
			'padron' => $id
		];
		return view('padrones.ddjj-historico' , $data);
	}

	/**
	 * Retorna un JSON para la datatable
	 * @param int $id
	 *
	 * @return json
	 */
	public function getListadoTabla($id){
		$lotes = DDJJSirge::join('sistema.lotes' , 'sistema.lotes.lote' , '=' , DB::raw('any(ddjj.sirge.lote)'))
			->join('sistema.subidas' , 'sistema.lotes.id_subida' , '=' , 'sistema.subidas.id_subida')
			->where('id_padron' , $id)
			->groupBy('ddjj.sirge.id_impresion')
			->groupBy('ddjj.sirge.lote')
			->groupBy('sistema.subidas.id_padron')
			->select('ddjj.sirge.*' , 'sistema.subidas.id_padron');
		if (Auth::user()->id_entidad == 2) {
			$lotes->where('id_provincia' , Auth::user()->id_provincia);
		}

		$lotes = $lotes->get();
		
		return Datatables::of($lotes)
			->addColumn('view' , function($lote){
				return '<a href="ddjj-sirge/' . $lote->id_padron . '/' . $lote->id_impresion . '" id_impresion="'. $lote->id_impresion .'" class="view-ddjj btn btn-success btn-xs"> Ver DDJJ <i class="fa fa-search"></i></a>';
			})
			->make(true);
	}

	/**
	 * Devuelve el nombre del padron correspondiente
	 * @param int $id
	 *
	 * @return string
	 */
	protected function getNombrePadron($id){
		switch ($id) {
			case '1':	return 'PRESTACIONES';
			case 2: return 'APLICACIÓN DE FONDOS';
			case 3: return 'COMPROBANTES';
			case 4: return 'OBRA SOCIAL PROVINCIAL';
			case 5: return 'PROGRAMA FEDERAL DE SALUD';
			case 6: return 'SUPERINTENDENCIA DE SERVICIOS DE SALUD';
			default: break;
		}
	}

	/**
	 * Devuelve la DDJJ Sirge elegida
	 * @param int $id
	 *
	 * @return resource
	 */
	public function getDDJJSirge($padron , $id){
		$resumen = [
			'in' => 0,
			'out' => 0,
			'mod' => 0
		];

		$lotes = DDJJSirge::join('sistema.lotes' , 'sistema.lotes.lote' , '=' , DB::raw('any(ddjj.sirge.lote)'))
			->where('id_impresion' , $id)
			->get();
		
		foreach ($lotes as $key => $lote){
			$resumen['in'] += $lote->registros_in;
			$resumen['out'] += $lote->registros_out;
			$resumen['mod'] += $lote->registros_mod;
		}

		$data = [
			'lotes' => $lotes,
			'nombre_padron' => $this->getNombrePadron($padron),
			'resumen' => $resumen,
			'jurisdiccion' => Provincia::where('id_provincia' , Auth::user()->id_provincia)->firstOrFail(),
			'ddjj' => DDJJSirge::findOrFail($id)
		];

		$pdf = PDF::loadView('pdf.ddjj.sirge' , $data);
    	return $pdf->download("ddjj-sirge-$id.pdf");
	}

	/** 
	 * Devuelve la vista para la DOIU 9
	 *
	 * @return null
	 */
	public function getDoiu9(){

		$dt = new \DateTime();
		$dt->modify('-1 month');
		$periodo = $dt->format('Y-m');

		$juris = D9::where('periodo_reportado' , $periodo)
				   ->where('version' , 1)
				   ->select('id_provincia')
				   ->count();

		$data = [
			'page_title' => 'Formulario DDJJ DOIU Nº 9',
			'numero' => $juris,
			'porcentaje' => ($juris/24)*100
		];
		return view('ddjj.doiu9' , $data);
	}

	/** 
	 * Devuelve la vista para la DOIU 9
	 *
	 * @return null
	 */
	public function getBackup(){

		$juris = Backup::where('periodo_reportado' , date('Y-m'))
				   ->select('id_provincia')
				   ->groupBy('id_provincia')
				   ->count();

		$data = [
			'page_title' => 'Formulario DDJJ Backup',
			'numero' => $juris,
			'porcentaje' => ($juris/24)*100
		];
		return view('ddjj.backup' , $data);
	}

	/**
	 * Devolver JSON para la datatables
	 *
	 * @return json
	 */
	public function getDoiu9Tabla() {
		$djs = D9::all();
		return Datatables::of($djs)
				->addColumn('action' , function($dj){
					return '<button impresion="'. $dj->id_impresion .'" class="download btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver ddjj</button>';
				})
				->make(true);
	}

	/**
	 * Devuelve la vista para ingresar el periodo a reportar
	 * 
	 * @return null
	 */
	public function getPeriodo($tipo){

		$data = [
			'tipodj' => $tipo,
			'page_title' => 'Verificación',
			'ruta_back' => 'ddjj-' . $tipo
		];
		return view('ddjj.periodo' , $data);
	}

	/**
	 * Devuelve el número de efectores integrantes
	 *
	 * @return int
	 */
	protected function getEfectoresIntegrantes(){
		return Efector::join('efectores.datos_geograficos' , 'efectores.efectores.id_efector' , '=' , 'efectores.datos_geograficos.id_efector')
				->where('id_provincia' , Auth::user()->id_provincia)
				->where('id_estado' , 1)
				->where('integrante' , 'S')
				->count();
	}

	/**
	 * Devuelve el número de efectores integrantes
	 *
	 * @return int
	 */
	protected function getEfectoresConvenio(){
		return Efector::join('efectores.datos_geograficos' , 'efectores.efectores.id_efector' , '=' , 'efectores.datos_geograficos.id_efector')
				->where('id_provincia' , Auth::user()->id_provincia)
				->where('id_estado' , 1)
				->where('integrante' , 'S')
				->where('compromiso_gestion' , 'S')
				->count();
	}

	/**
	 * Verifica que la DDJJ no haya sido generada para ese período
	 * @param periodo $string
	 * @param tipo $tipo
	 *
	 * @return int
	 */
	public function checkPeriodo($tipo , $periodo){

		$date = \DateTime::createFromFormat('Y-m' , $periodo);
		$min = \DateTime::createFromFormat('Ym' , '201501');
		$max = new \DateTime;
		$max->modify('-1 month');

		if ($date < $min || $date > $max) {
			return response('Periodo no permitido' , 422);
		}

		switch ($tipo) {
			case 'doiu-9':
				$impreso = D9::where('periodo_reportado' , $periodo)
						 ->where('id_provincia' , Auth::user()->id_provincia)
						 ->count();
				$titulo = 'Formulario de DDJJ Información Priorizada - DOIU Nº 9';
				$page = 'ddjj.d9.main';
				break;
			case 'backup':
				$impreso = Backup::where('periodo_reportado' , $periodo)
						 ->where('id_provincia' , Auth::user()->id_provincia)
						 ->count();
				$titulo = 'Formulario de DDJJ Backup';
				$page = 'ddjj.backup.main';
				break;
		}

		$data = [
			'page_title' => $titulo,
			'tipodj' => $tipo,
			'version' => $impreso,
			'periodo' => $periodo
		];

		if (! $impreso) {
			$data['ruta_back'] = 'ddjj-' . $tipo;
			$data['efectores_integrantes'] = $this->getEfectoresIntegrantes();
			$data['efectores_convenio'] = $this->getEfectoresConvenio();
			return view($page , $data);
		} else {
			$data['ruta_back'] = 'ddjj-periodo/' . $tipo;
			return view('ddjj.motivo-reimpresion' , $data);
		}
	}

	/** 
	 * Devuelve la vista para la reimpresión de la DDJJ
	 * @param string $tipodj
	 * @param string $periodo
	 * @param Request $r
	 *
	 * @return null
	 */
	public function reimpresion($tipodj , $periodo , $version , Request $r){

		switch ($tipo) {
			case 'doiu-9':
				$page = 'ddjj.d9.main';
				$titulo = 'Formulario de DDJJ Información Priorizada - DOIU Nº 9';
				break;
			case 'backup':
				$page = 'ddjj.backup.main';
				$titulo = 'Formulario de DDJJ Backup';
				break;
		}

		$data = [
			'page_title' => $titulo,
			'motivo' => $r->motivo,
			'tipodj' => $tipodj,
			'version' => $version,
			'periodo' => $periodo
		];

		return view($page , $data);
	}

	/**
	 * Genera la DDJJ
	 * @param Request $r
	 *
	 * @return string
	 */
	public function postDoiu9(DOIU9Request $r) {
		
		$d9 = new D9;
		$d9->id_provincia = Auth::user()->id_provincia;
		$d9->id_usuario = Auth::user()->id_usuario;
		$d9->periodo_reportado = $r->periodo;
		$d9->efectores_integrantes = $this->getEfectoresIntegrantes();
		$d9->efectores_convenio = $this->getEfectoresConvenio();
		$d9->periodo_tablero_control = $r->periodo_tablero;
		$d9->fecha_cuenta_capitas = $r->fecha_cuenta_capitas;
		$d9->periodo_cuenta_capitas = $r->periodo_cuenta_capitas;
		$d9->fecha_sirge = $r->fecha_sirge;
		$d9->periodo_sirge = $r->periodo_sirge;
		$d9->fecha_reporte_bimestral = $r->fecha_reporte_bimestral;
		$d9->bimestre = $r->bimestre;
		$d9->anio_bimestre = $r->anio_bimestre;
		$d9->version = $r->version;
		$d9->motivo_reimpresion = $r->motivo;
		if ($d9->save()){
			return 'Se ha enviado la DDJJ de información priorizada a su casilla de correo';
		}
	}

	/**
	 * Devuelve el PDF con la DDJJ DOIU9
	 * @param int $id
	 *
	 * @return null
	 */
	public function getPdfDoiu9(){
		$d = D9::find(639);
		$data = [
			'ddjj' => $d,
			'mensaje' => Parametro::find(2)
		];
		$pdf = PDF::loadView('pdf.ddjj.doiu9' , $data);
		return $pdf->stream();
	}
}
