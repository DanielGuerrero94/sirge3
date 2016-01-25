<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Database\QueryException;
use Validator;
use Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;
use App\Models\Lote;
use App\Models\Rechazo;
use App\Models\Fondo;

class FondosController extends Controller
{
    private 
		$_rules = [
			'efector' => 'required|exists:efectores.efectores,cuie',
			'fecha_gasto' => 'required|date_format:Y-m-d',
			'periodo' => 'required|date_format:Ym',
			'numero_comprobante' => 'max:50',
			'codigo_gasto' => 'required|exists:fondos.codigos_gasto,codigo_gasto',
			'subcodigo_gasto' => 'required|exists:fondos.subcodigos_gasto,subcodigo_gasto',
			'efector_cesion' => 'required_if:codigo_gasto,6',
			'monto' => 'required|numeric',
			'concepto' => 'max:200'
		],
		$_data = [
			'efector',
			'fecha_gasto',
			'periodo',
			'numero_comprobante',
			'codigo_gasto',
			'subcodigo_gasto',
			'efector_cesion',
			'monto',
			'concepto',
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
		try {
			$fh = fopen ('../storage/uploads/fondos/' . $info->nombre_actual , 'r');
		} catch (ErrorException $e) {
			return false;
		}
		return $fh;
	}

	/**
	 * Arma el array de prestacion
	 * @param array $linea
	 *
	 * @return array
	 */
	protected function armarArray($linea , $lote) {

		$linea[2] = str_replace('-', '', $linea[2]);
		$codigos = explode('.' , $linea[4]);
		$fondo = [
			$linea[0],
			$linea[1],
			$linea[2],
			$linea[3],
			$codigos[0],
			$codigos[1],
			$linea[5],
			$linea[6],
			$linea[7],
			$lote
		];

		return $fondo;
	}

	/**
	 * Procesa el archivo de comprobantes
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id){
		$lote = $this->nuevoLote($id);
		$fh = $this->abrirArchivo($id);
		
		if (!$fh){
			return response('Error' , 422);
		}

		fgets($fh);
		while (!feof($fh)){
			$linea = explode (';' , trim(fgets($fh) , "\r\n"));
			if (count($linea) != 1){
				$fondo_raw = array_combine($this->_data, $this->armarArray($linea , $lote));
				$v = Validator::make($fondo_raw , $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = json_encode($fondo_raw);
					$this->_error['motivos'] = json_encode($v->errors());
					$this->_error['created_at'] = date("Y-m-d H:i:s");					
					Rechazo::insert($this->_error);
				} else {
					try {
						Fondo::insert($fondo_raw);
						$this->_resumen['insertados'] ++;
					} catch (QueryException $e) {
						$this->_resumen['rechazados'] ++;
						$this->_error['lote'] = $lote;
						$this->_error['registro'] = json_encode($fondo_raw);
						if ($e->getCode() == 23505){
							$this->_error['motivos'] = '{"pkey" : ["Registro ya informado"]}';
						} else {
							$this->_error['motivos'] = '{"' . $e->getCode() . '" : ["' . $e->getMessage() . '"]}';
						}
						Rechazo::insert($this->_error);
					}
				}
			}
		}
		$this->actualizaLote($lote , $this->_resumen);
		$this->actualizaSubida($id);
		return response()->json($this->_resumen);	
	}
}
