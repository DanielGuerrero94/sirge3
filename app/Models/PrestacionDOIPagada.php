<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestacionDOIPagada extends Model
{
	protected $table = 'prestaciones.prestaciones_doi_pagadas'; 
	//
	protected $fillable = [
		'id_prestacion',
		'prestacion_codigo',
		'cuie',
		'prestacion_fecha',
		'beneficiario_apellido',
		'beneficiario_nombre',
		'beneficiario_clave',
		'beneficiario_tipo_documento',
		'beneficiario_clase_documento',
		'beneficiario_nro_documento',
		'beneficiario_sexo',
		'beneficiario_nacimiento',
		'valor_unitario_facturado',
		'cantidad_facturado',
		'importe_prestacion_facturado',
		'id_factura',
		'factura_nro',
		'factura_fecha',
		'factura_importe_total',
		'factura_fecha_recepcion',
		'alta_complejidad'
	];

	public function __construct() {
		parent::__construct();
		$this->id_provincia = '02';
	}

	

	
}
