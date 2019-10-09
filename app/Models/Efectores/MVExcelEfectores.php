<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class MVExcelEfectores extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.mv_efectores_completo';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Mostrar el nombre del efector.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function getNombreEfectorAttribute($value) {
		return html_entity_decode($value);
	}

	/**
	 * Guardar el domicilio del efector.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setDomicilioAttribute($value) {
		$this->attributes['domicilio'] = mb_strtoupper($value);
	}

	/**
	 * Guardar el codigo postal del efector.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setCodigoPostalAttribute($value) {
		$this->attributes['codigo_postal'] = mb_strtoupper($value);
	}

	/**
	 * Guardar la denominación legal del efector.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setDenominacionLegalAttribute($value) {
		$this->attributes['denominacion_legal'] = mb_strtoupper($value);
	}

	/**
	 * Guardar la dependencia sanitaria del efector.
	 *
	 * @param  string  $value
	 * @return string
	 */
	public function setDependenciaSanitariaAttribute($value) {
		$this->attributes['dependencia_sanitaria'] = mb_strtoupper($value);
	}
}
