<?php

namespace App\Models\Tablero;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tablero.ingresos';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Devuelve la provincia
	 */
	public function provincias() {
		return $this->hasOne('App\Models\Geo\Provincia', 'id_provincia', 'provincia');
	}

	/**
	 * Get the indicator value.
	 *
	 * @param  string  $value
	 * @return string
	 */
	/*
public function getIndicadorAttribute($value) {
$conv = array("|" => ".");
return strtr($value, $conv);
;
}*/
}
