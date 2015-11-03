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
use App\Models\Prestacion;

class PrestacionesController extends Controller
{
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
	 * Arma el array de prestacion
	 * @param array $linea
	 *
	 * @return array
	 */
	protected function armarArray($linea , $lote) {
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
			$lote,
			json_encode($datos_reportables)
		];
		return $prestacion;
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
			$fh = fopen ('../storage/uploads/prestaciones/' . $info->nombre_actual , 'r');
		} catch (ErrorException $e) {
			return false;
		}
		return $fh;
	}

	/**
	 * Procesa el archivo de prestaciones
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
			if (count($linea) != 1) {
				$prestacion_raw = array_combine($this->_data, $this->armarArray($linea , $lote));
				$v = Validator::make($prestacion_raw , $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = json_encode($prestacion_raw);
					$this->_error['motivos'] = json_encode($v->errors());
					Rechazo::insert($this->_error);
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
									$this->_error['motivos'] = '{"pkey" : ["Registro ya informado"]}';
								} else {
									$this->_error['motivos'] = '{"' . $e->getCode() . '" : ["' . $e->getMessage() . '"]}';
								}
								Rechazo::insert($this->_error);
							}
							break;
						case 'M':
							$prestacion = Prestacion::where('numero_comprobante' , $prestacion_raw['numero_comprobante'])
													->where('codigo_prestacion' , $prestacion_raw['codigo_prestacion'])
													->where('subcodigo_prestacion' , $prestacion_raw['subcodigo_prestacion'])
													->where('fecha_prestacion' , $prestacion_raw['fecha_prestacion'])
													->where('clave_beneficiario' , $prestacion_raw['clave_beneficiario'])
													->where('orden' , $prestacion_raw['orden']);
							
							if ($prestacion->count()){
								$prestacion = $prestacion->firstOrFail();
								$prestacion->estado = 'D';
								if ($prestacion->save()){
									$this->_resumen['modificados'] ++;
								}
							} else {
								$this->_resumen['rechazados'] ++;
								$this->_error['lote'] = $lote;
								$this->_error['registro'] = json_encode($prestacion_raw);
								$this->_error['motivos'] = '{"modificacion" : ["Registro a modificar no encontrado"]}';
								Rechazo::insert($this->_error);
							}
							break;
					}
				}
			}
		}
		$this->actualizaLote($lote , $this->_resumen);
		$this->actualizaSubida($id);
		return response()->json($this->_resumen);
	}
}
