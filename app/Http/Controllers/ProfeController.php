<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Rechazo;
use App\Models\Lote;
use App\Models\Subida;
use App\Models\SubidaOsp;
use App\Models\PUCO\Profe;
use App\Models\PUCO\ProcesoPuco as Puco;

class ProfeController extends Controller
{
    private 
		$_rules = [
			'tipo_documento' => 'required|exists:sistema.tipo_documento,tipo_documento',
			'numero_documento' => 'required|digits:5,8',
			'nombre_apellido' => 'required|max:255',
			'sexo' => 'required|in:F,M',
			'id_beneficiario_profe' => 'numeric',
			'id_parentezco' => 'numeric'
		],
		$_data = [
			'tipo_documento',
			'numero_documento',
			'nombre_apellido',
			'sexo',
			'fecha_nacimiento',
			'fecha_alta',
			'id_beneficiario_profe',
			'id_parentezco',
			'ley_aplicada',
			'fecha_desde',
			'fecha_hasta',
			'id_provincia',
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
		return file('../storage/uploads/profe/' . $info->nombre_actual);
	}

	/**
	 * Limpia el tipo de documento
	 * @param string $tipo
	 *
	 * @return string
	 */
	protected function sanitizeTipoDoc($tipo){
		$tipos = ['DU'];

		if (in_array($tipo, $tipos)){
			return 'DNI';
		} else {
			return $tipo;
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
	 * Actualiza el proceso
	 * @param int $lote
	 *
	 * @return bool
	 */
	public function actualizarProceso($lote , $codigo) {
		$p = Puco::join('sistema.lotes' , 'sistema.lotes.lote' , '=' , 'puco.procesos_obras_sociales.lote')
				 ->join('sistema.subidas' , 'sistema.subidas.id_subida' , '=' , 'sistema.lotes.id_subida')
				 ->join('sistema.subidas_osp' , 'sistema.subidas_osp.id_subida' , '=' , 'sistema.subidas.id_subida')
				 ->select('puco.procesos_obras_sociales.*' , 'sistema.subidas_osp.*')
				 ->where('periodo' , date('Ym'))
				 ->where('codigo_osp' , $codigo)
				 ->get();
		if ($p->count()){
			$np = Puco::find($p[0]->lote);
		} else {
			$np = new Puco;
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
		DB::statement('truncate table puco.beneficiarios_profe');
		$bulk = [];
		$lote = $this->nuevoLote($id);
		$registros = $this->abrirArchivo($id);

		foreach ($registros as $key => $registro) {
			$linea = explode("\t" , trim($registro , "\r\n"));
			if (count($linea) == 12){
				array_push($linea, $lote);
				$profe_raw = array_combine($this->_data, $linea);
				$profe_raw['tipo_documento'] = $this->sanitizeTipoDoc(strtoupper($profe_raw['tipo_documento']));
				$v = Validator::make($profe_raw , $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = json_encode($profe_raw);
					$this->_error['motivos'] = json_encode($v->errors());
					$this->_error['created_at'] = date("Y-m-d H:i:s");
					Rechazo::insert($this->_error);
				} else {
					$this->_resumen['insertados'] ++;
					$profe_raw['tipo_documento'] = $profe_raw['tipo_documento'];
					$profe_raw['nombre_apellido'] = $this->sanitizeNombreApellido($profe_raw['nombre_apellido']);
					$bulk[] = $profe_raw;
					if (sizeof($bulk) % 4000 == 0){
						Profe::insert($bulk);
						unset($bulk);
						$bulk = [];
					}
				}
			} else {
				$this->_resumen['rechazados'] ++;
				$this->_error['lote'] = $lote;
				$this->_error['registro'] = json_encode($linea);
				$this->_error['motivos'] = '{"registro invalido" : ["El número de campos es incorrecto"]}';
				$this->_error['created_at'] = date("Y-m-d H:i:s");
				Rechazo::insert($this->_error);
			}
		}

		if (sizeof($bulk)){
			Profe::insert($bulk);
		}

		$this->actualizaLote($lote , $this->_resumen);
		$this->actualizaSubida($id);
		$this->actualizarProceso($lote , $this->getCodigoOsp($id));
		return response()->json($this->_resumen);
	}
}
