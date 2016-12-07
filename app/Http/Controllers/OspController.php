<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use Session;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Rechazo;
use App\Models\Lote;
use App\Models\LoteAceptado;
use App\Models\LoteRechazado;
use App\Models\Subida;
use App\Models\SubidaOsp;
use App\Models\PUCO\Osp;
use App\Models\PUCO\ProcesoPuco as Pucop;
use App\Models\Usuario;

class OspController extends Controller
{
    private 
		$_rules = [
			'tipo_documento' => 'required|exists:sistema.tipo_documento,tipo_documento',
			//'tipo_documento' => 'required|in:DNI,LE,LC,CI,OTR',
			'numero_documento' => 'required|digits_between:4,8',
			'nombre_apellido' => 'required|max:255',
			// 'sexo' => 'required|in:F,M',
			'tipo_afiliado' => 'required|in:T,A',
			'codigo_os' => 'required|exists:puco.obras_sociales,codigo_osp',
		],
		$_data = [
			'tipo_documento',
			'numero_documento',
			'nombre_apellido',
			'sexo',
			'codigo_os',
			'codigo_postal',
			'id_provincia',
			'tipo_afiliado',
			'lote'
		],
		$_resumen = [
			'insertados' => 0,
			'rechazados' => 0,
			'modificados' => 0
		],
		$_error = [
			'lote' => '',
			'registro' => '',
			'motivos' => ''
		];

	/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * Crea un nuevo lote
	 * @param int $id_subida
	 *
	 * @return int
	 */
	protected function nuevoLote($id_subida){
		$l = new Lote;
		$l->id_subida = $id_subida;
		$l->id_usuario = Auth::user()->id_usuario;
		$l->id_provincia = Auth::user()->id_provincia;
		$l->registros_in = 0;
		$l->registros_out = 0;
		$l->registros_mod = 0;
		$l->id_estado = 1;
		$l->save();
		return $l->lote;
	}

	/**
	 * Actualiza el lote con los datos procesados
	 * @param int $lote
	 * @param array $resumen
	 *
	 * @return bool
	 */
	protected function actualizaLote($lote , $resumen) {
		$l = Lote::findOrFail($lote);
		$l->registros_in = $resumen['insertados'];
		$l->registros_out = $resumen['rechazados'];
		$l->registros_mod = $resumen['modificados'];
		$l->fin = 'now';
		return $l->save();
	}

	/**
	 * Actualiza el archivo con los datos procesados
	 * @param int $id
	 *
	 * @return bool
	 */
	protected function actualizaSubida($subida) {
		$s = Subida::findOrFail($subida);
		$s->id_estado = 2;
		return $s->save();
	}

	/**
	 * Abre un archivo y devuelve un handler
	 * @param int $id
	 *
	 * @return resource
	 */
	protected function abrirArchivo($id){
		$info = Subida::findOrFail($id);
		return file('../storage/uploads/osp/' . $info->nombre_actual);
	}

	/**
	 * Limpia el tipo de documento
	 * @param string $tipo
	 *
	 * @return string
	 */
	protected function sanitizeTipoDoc($tipo){
		$tipos = ['DU'];

		if (in_array(strtoupper($tipo), $tipos))
		{
			return 'DNI';
		} else {
			return trim($tipo);
		}
	}

	/**
	 * Limpia el nombre y apellido
	 * @param string $data
	 *
	 * @return string
	 */
	protected function sanitizeNombreApellido($data){
		return mb_convert_encoding($data , 'UTF-8' , "ISO-8859-15");
	}

	/**
	 * Limpia el tipo de afiliado
	 * @param string $data
	 *
	 * @return string
	 */
	protected function sanitizeTipoAfiliado($data){		
		if ($data <> 'T' && $data <> 'A') {
			return 'A';
		}
		else{
			return $data;
		}	
	}

	/**
	 * Actualiza el proceso
	 * @param int $lote
	 *
	 * @return bool
	 */
	public function actualizarProceso($lote , $codigo) {

		
		$p = Pucop::join('sistema.lotes' , 'sistema.lotes.lote' , '=' , 'puco.procesos_obras_sociales.lote')
			 ->join('sistema.subidas' , 'sistema.subidas.id_subida' , '=' , 'sistema.lotes.id_subida')
			 ->join('sistema.subidas_osp' , 'sistema.subidas_osp.id_subida' , '=' , 'sistema.subidas.id_subida')
			 ->select('puco.procesos_obras_sociales.*' , 'sistema.subidas_osp.*')
			 ->where('periodo' , date('Ym'))
			 ->where('codigo_osp' , $codigo)
			 ->first();
	
		if (isset($p->lote)){
			
			$np = Pucop::find($p->lote);
			$lote_o = Lote::find($p->lote);
			$lote_o->id_estado = 4;
			$lote_o->save();
			LoteAceptado::where('lote',$p->lote)->delete();
			if(!LoteRechazado::where('lote',$p->lote)){
				$loter = new LoteRechazado();
				$loter->lote = $p->lote;
				$loter->id_usuario = Usuario::superAdmin()->id_usuario;
				$loter->fecha_rechazado = date("Y-m-d H:i:s");
				$loter->save();
			}			
			Osp::where('codigo_os' , $codigo)->where('lote', $p->lote)->delete();

		} else {			
			$np = new Pucop;			
		}

		$np->lote = $lote;
		$np->periodo = date('Ym');

		return $np->save();
	}

	/**
	 * Devuelve el código de la OSP a procesar
	 * @param int $id
	 *
	 * @return int
	 */
	protected function getCodigoOsp($id) {
		$s = SubidaOsp::select('codigo_osp')->where('id_subida' , $id)->firstOrFail();
		return $s->codigo_osp;
	}

	/**
	 * Procesa el archivo de prestaciones
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id){

		if (Session::get('recent_post')){
			if(time() - Session::get('recent_post_time') <= 5){
				return response('Multiple procesamiento de archivos en el mismo padron. Espere a que termine el anterior',422);	
			}
			else{
				Session::set('recent_post', false);
				Session::set('recent_post_time', time());				
			}			
		}
    	else{
    		Session::set('recent_post', true);
    		Session::set('recent_post_time', time());	
    	}

		$bulk = [];		
		$lote = $this->nuevoLote($id);
		$registros = $this->abrirArchivo($id);

		foreach ($registros as $key => $registro) {
			$linea = explode('||' , trim($registro , "\r\n"));
			if (count($linea) == 8){
				array_push($linea, $lote);
				$osp_raw = array_combine($this->_data, $linea);
				$osp_raw['tipo_documento'] = strtoupper($this->sanitizeTipoDoc($osp_raw['tipo_documento']));
				$osp_raw['nombre_apellido'] = $this->sanitizeNombreApellido($osp_raw['nombre_apellido']);
				$osp_raw['tipo_afiliado'] = $this->sanitizeTipoAfiliado($osp_raw['tipo_afiliado']);


				$v = Validator::make($osp_raw , $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = json_encode($osp_raw);
					$this->_error['motivos'] = json_encode($v->errors());
					$this->_error['created_at'] = date("Y-m-d H:i:s");
					Rechazo::insert($this->_error);
				} else {
					$this->_resumen['insertados'] ++;
					$bulk[] = $osp_raw;
					if (sizeof($bulk) % 6000 == 0){
						Osp::insert($bulk);
						unset($bulk);
						$bulk = [];
					}
				}
			} 
			else if(count($linea) == 1 && $linea[0] == ''){
				$this->_resumen['rechazados'] ++;
				$this->_error['lote'] = $lote;
				$this->_error['registro'] = json_encode($linea);
				$this->_error['motivos'] = '{"registro invalido" : ["Linea en blanco"]}';
				$this->_error['created_at'] = date("Y-m-d H:i:s");
				Rechazo::insert($this->_error);
			}	
			else {
				$this->_resumen['rechazados'] ++;
				$this->_error['lote'] = $lote;
				$this->_error['registro'] = json_encode($linea);
				$this->_error['motivos'] = '{"registro invalido" : ["El número de campos es incorrecto"]}';
				$this->_error['created_at'] = date("Y-m-d H:i:s");
				Rechazo::insert($this->_error);
			}
		}

		if (sizeof($bulk)){
			Osp::insert($bulk);
		}

		$this->actualizaLote($lote , $this->_resumen);
		$this->actualizaSubida($id);
		$this->actualizarProceso($lote , $this->getCodigoOsp($id));
		return response()->json($this->_resumen);
	}

	/**
	 * Devuelve información sobre si una OSP ya fue cargada en el mes o no
	 * @param int $codigo
	 *
	 * @return bool
	 */
	public function checkPeriodo($codigo) {
		$p = Pucop::join('sistema.lotes' , 'sistema.lotes.lote' , '=' , 'puco.procesos_obras_sociales.lote')
				 ->join('sistema.subidas' , 'sistema.subidas.id_subida' , '=' , 'sistema.lotes.id_subida')
				 ->join('sistema.subidas_osp' , 'sistema.subidas_osp.id_subida' , '=' , 'sistema.subidas.id_subida')
				 ->select('puco.procesos_obras_sociales.*' , 'sistema.subidas_osp.*')
				 ->where('periodo' , date('Ym'))
				 ->where('codigo_osp' , $codigo)
				 ->where('sistema.lotes.id_estado' , '<>' , 4)
				 ->get();
		return $p->count();
	}
}
