<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Database\QueryException;
use Validator;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Rechazo;
use App\Models\Lote;
use App\Models\Subida;
use App\Models\Osp;
use App\Models\ProcesoPuco as Puco;

class OspController extends Controller
{
    private 
		$_rules = [
			'tipo_documento' => 'required|in:DNI,LE,LC,CI,OTR',
			'numero_documento' => 'required|numeric',
			'nombre_apellido' => 'required|max:255',
			'sexo' => 'required|in:F,M',
			'tipo_afiliado' => 'required|in:T,A',
			'codigo_os' => 'required|numeric',
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

		if (in_array($tipo, $tipos)){
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
	 * Procesa el archivo de prestaciones
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id){
		$bulk = [];
		$lote = $this->nuevoLote($id);
		$registros = $this->abrirArchivo($id);

		foreach ($registros as $key => $registro) {
			$linea = explode('||' , trim($registro , "\r\n"));
			if (count($linea) == 8){
				array_push($linea, $lote);
				$osp_raw = array_combine($this->_data, $linea);
				$osp_raw['tipo_documento'] = $this->sanitizeTipoDoc($osp_raw['tipo_documento']);
				$osp_raw['nombre_apellido'] = $this->sanitizeNombreApellido($osp_raw['nombre_apellido']);
				$codigo_osp = $osp_raw['codigo_os'];
				$v = Validator::make($osp_raw , $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = json_encode($osp_raw);
					$this->_error['motivos'] = json_encode($v->errors());
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
			} else {
				$this->_resumen['rechazados'] ++;
				$this->_error['lote'] = $lote;
				$this->_error['registro'] = json_encode($linea);
				$this->_error['motivos'] = '{"registro invalido" : ["El número de campos es incorrecto"]}';
				Rechazo::insert($this->_error);
			}
		}

		if (sizeof($bulk)){
			Osp::insert($bulk);
		}

		$this->actualizaLote($lote , $this->_resumen);
		$this->actualizaSubida($id);
		$registro = Puco::where('codigo_osp' , );
		return response()->json($this->_resumen);
	}
}
