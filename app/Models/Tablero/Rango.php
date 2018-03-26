<?php

namespace App\Models\Tablero;

use Illuminate\Database\Eloquent\Model;

class Rango extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tablero.rangos';

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
	public function provincia() {
		return $this->hasOne('App\Models\Geo\Provincia', 'id_provincia', 'id_provincia');
	}
}
