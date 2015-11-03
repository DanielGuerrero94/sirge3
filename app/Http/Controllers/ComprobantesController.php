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
use App\Models\Comprobante;

class ComprobantesController extends Controller
{
	private 
		$_rules = [
			'efector' => 'required|exists:efectores.efectores,cuie',
			'numero_comprobante' => 'required|max:50',
			'tipo_comprobante' => 'required|in:FC,ND,NC',
			'fecha_comprobante' => 'required|date_format:Y-m-d',
			'fecha_recepcion' => 'required|date_format:Y-m-d',
			'fecha_notificacion' => 'required|date_format:Y-m-d',
			'fecha_liquidacion' => 'required|date_format:Y-m-d',
			'fecha_debito_bancario' => 'required|date_format:Y-m-d',
			'importe' => 'required|numeric',
			'importe_pagado' => 'required|numeric',
			'factura_debitada' => 'max:50',
			'concepto' => 'max:200'
		],
		$_data = [
			'efector',
			'numero_comprobante',
			'tipo_comprobante',
			'fecha_comprobante',
			'fecha_recepcion',
			'fecha_notificacion',
			'fecha_liquidacion',
			'fecha_debito_bancario',
			'importe',
			'importe_pagado',
			'factura_debitada',
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
			$fh = fopen ('../storage/uploads/comprobantes/' . $info->nombre_actual , 'r');
		} catch (ErrorException $e) {
			return false;
		}
		return $fh;
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
				array_push($linea, $lote);
				$comprobante_raw = array_combine($this->_data, $linea);
				$v = Validator::make($comprobante_raw , $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = json_encode($comprobante_raw);
					$this->_error['motivos'] = json_encode($v->errors());
					Rechazo::insert($this->_error);
				} else {
					try {
						Comprobante::insert($comprobante_raw);
						$this->_resumen['insertados'] ++;
					} catch (QueryException $e) {
						$this->_resumen['rechazados'] ++;
						$this->_error['lote'] = $lote;
						$this->_error['registro'] = json_encode($comprobante_raw);
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
