<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class PrestacionDOIPagada extends Model
{
	protected $table = 'prestaciones.prestaciones_doi_pagadas'; 
	//
	protected $fillable = [
		'id_provincia',
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
		'alta_complejidad',
        	'id_liquidacion',
	        'liquidacion_fecha',
	        'valor_unitario_aprobado',
	        'cantidad_aprobada',
	        'importe_prestacion_aprobado',
	        'id_dato_reportable_1',
	        'dato_reportable_1',
	        'id_dato_reportable_2',
	        'dato_reportable_2',
	        'id_dato_reportable_3',
	        'dato_reportable_3',
	        'id_dato_reportable_4',
	        'dato_reportable_4',
	        'id_op',
	        'numero_op',
	        'fecha_op',
	        'importe_total_op',
	        'numero_expte',
	        'fecha_debito_bancario',
	        'importe_debito_bancario',
	        'fecha_notificacion_efector'
	];

	public function setIdDatoReportable1Attribute($value)
	{
		$this->attributes['id_dato_reportable_1'] = (int) $value;
	}

	public function setIdDatoReportable2Attribute($value)
	{
		$this->attributes['id_dato_reportable_2'] = (int) $value;
	}

	public function setIdDatoReportable3Attribute($value)
	{
		$this->attributes['id_dato_reportable_3'] = (int) $value;
	}

	public function setIdDatoReportable4Attribute($value)
	{
		$this->attributes['id_dato_reportable_4'] = (int) $value;
	}

	public function setIdOpAttribute($value)
	{
		$this->attributes['id_op'] = (int) $value;
	}

	public function setFechaOpAttribute($value)
	{
		$this->attributes['fecha_op'] = $value == ""?null:$value;
	}

	public function setImporteTotalOpAttribute($value)
	{
		$this->attributes['importe_total_op'] = (float) $value;
	}



	public function __construct(array $attributes=[]) {
            $user = Auth::user();
            $attributes['id_provincia'] = $user['id_provincia'];
            parent::__construct($attributes);
	}
	
}
