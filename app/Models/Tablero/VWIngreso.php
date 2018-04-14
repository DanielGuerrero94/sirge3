<?php

namespace App\Models\Tablero;

use Illuminate\Database\Eloquent\Model;

class VWIngreso extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tablero.vw_ingresos';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
