<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.modulos';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_modulo';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Obtener todos los menues en que figure el módulo
	 */
	public function menues() {
		return $this->hasMany('App\Classes\ModuloMenu', 'id_modulo', 'id_modulo');
	}
}
