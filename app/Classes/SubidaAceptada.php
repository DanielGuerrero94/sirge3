<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class SubidaAceptada extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.subidas_aceptadas';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_subida';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Obtener el registro de subida
	 */
	public function subida() {
		return $this->belongsTo('App\Classes\Subida', 'id_subida', 'id_subida');
	}
}
