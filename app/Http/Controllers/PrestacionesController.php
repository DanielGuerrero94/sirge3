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
use App\Models\Prestacion;

class PrestacionesController extends Controller
{

	/**
	 * Defino las reglas para la validación de prestaciones
	 */

	private 
		$_rules = [
			'operacion' => 'required|in:A,M',
			'estado' => 'required|in:L,D',
			'numero_comprobante' => 'required|max:50',
			'codigo_prestacion' => 'required|exists:pss.codigos,codigo_prestacion',
			'subcodigo_prestacion' => 'max:3',
			'precio_unitario' => 'required|numeric',
			'fecha_prestacion' => 'required|date_format:Y-m-d',
			'clave_beneficiario' => 'required|exists:beneficiarios.beneficiarios,clave_beneficiario',
			'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
			'clase_documento' => 'in:P,A',
			'numero_documento' => 'max:8',
			'orden' => 'required|numeric',
			'efector' => 'required|exists:efectores.efectores,cuie'
		],
		$_data = [
			'operacion',
			'id_provincia',
			'estado',
			'numero_comprobante',
			'codigo_prestacion',
			'subcodigo_prestacion',
			'precio_unitario',
			'fecha_prestacion',
			'clave_beneficiario',
			'tipo_documento',
			'clase_documento',
			'numero_documento',
			'orden',
			'efector',
			'lote',
			'datos_reportables'
		],
		$_resumen = [
			'insertados' => 0,
			'rechazados' => 0,
			'modificados' => 0
		],
		$_error = [
			'lote' => '',
			'registro' => '',
			'error' => ''
		],
		$_nro_linea = 1;

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
		try {
			$l->save();
			return $l->lote;
		} catch (ErrorExepction $e) {
			return $e;
		}
	}

	/**
	 * Procesa el archivo de prestaciones
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id){
		$prestaciones_ins = [];
		$info = Subida::findOrFail($id);
		$lote = $this->nuevoLote($id);

		try {
			$fh = fopen ('../storage/uploads/prestaciones/' . $info->nombre_actual , 'r');
		} catch (ErrorException $e) {
			return $e;
		}

		fgets($fh);
		while (! feof($fh)){

			$linea = explode (';' , trim(fgets($fh) , "\r\n"));
			$this->_nro_linea++;

			if (count($linea) != 1) {
				$datos_reportables = [
					$linea[11] => $linea[12],
					$linea[13] => $linea[14],
					$linea[15] => $linea[16],
					$linea[17] => $linea[18]
				];

				$prestacion = [
					$linea[0],
					Auth::user()->id_provincia,
					$linea[1],
					$linea[2],
					$linea[3],
					$linea[4],
					$linea[5],
					$linea[6],
					$linea[7],
					$linea[8],
					$linea[9],
					$linea[10],
					$linea[19],
					$linea[20],
					$lote,
					json_encode($datos_reportables)
				];

				$prestacion_raw = array_combine($this->_data, $prestacion);
				$v = Validator::make($prestacion_raw , $this->_rules);

				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = $prestacion_raw;
					$this->_error['error'] = json_encode($v->errors());
					// echo '<pre>' , print_r($this->_error) , '</pre>';
				} else {
					$operacion = array_shift($prestacion_raw);
					switch ($operacion) {
						case 'A':
							try {
								Prestacion::insert($prestacion_raw);
								$this->_resumen['insertados'] ++;
							} catch (QueryException $e) {
								$this->_resumen['rechazados'] ++;
								$this->_error['lote'] = $lote;
								$this->_error['registro'] = json_encode($prestacion_raw);
								if ($e->getCode() == 23505){
									$this->_error['error'] = '{"pkey" : ["Registro ya informado"]}';
								} else {
									$this->_error['error'] = '{"' . $e->getCode() . '" : ["' . $e->getMessage() . '"]}';
								}
							}
							break;
						case 'M':
							break;
					}
				}
			}
		}
		// if (Prestacion::insert($prestaciones_ins)){
		return '<pre>' . print_r($this->_resumen) . '</pre>';
		// }
	}
}
