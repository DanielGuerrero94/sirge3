<?php

namespace App\Http\Controllers;

use ErrorException;
use Validator;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;

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
			'clave_beneficiario' => 'required|size:16' ,
			'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
			'clase_documento' => 'in:P,A',
			'numero_documento' => 'max:8',
			'orden' => 'required|numeric',
			'efector' => 'required|exists:efectores.efectores,cuie'
		],
		$_data = [
			'operacion',
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
			'datos_reportables'
		],
		$_errores,
		$_nro_linea = 0;

	/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * Procesa el archivo de prestaciones
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id){
		
		$info = Subida::findOrFail($id);

		try {
			$fh = fopen ('../storage/uploads/prestaciones/' . $info->nombre_actual , 'r');
		} catch (ErrorException $e) {
			return $e;
		}

		fgets($fh);
		while (! feof($fh)){

			$linea = explode (';' , trim(fgets($fh) , "\r\n"));
			
			if (count($linea) != 1) {
				$datos_reportables = [
					$linea[11] => $linea[12],
					$linea[13] => $linea[14],
					$linea[15] => $linea[16],
					$linea[17] => $linea[18]
				];

				$prestacion = [
					$linea[0],
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
					json_encode($datos_reportables)
				];

				$data = array_combine($this->_data, $prestacion);

				//echo '<pre>' , print_r($data) , '</pre>';
				
				$v = Validator::make($data , $this->_rules);

				if ($v->fails()) {
					echo json_encode($v->invalid()) . $v->errors() . json_encode($v->getFallbackMessages());
				}
			}
		}
	}
}
