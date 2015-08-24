<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subida extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.subidas';

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
	 * Obtener el registro aceptado de la subida.
	 */
	public function aceptado(){
		return $this->hasOne('App\Models\SubidaAceptada', 'id_subida', 'id_subida');
	}

	/**
	 * Obtener el registro eliminado de la subida.
	 */
	public function aceptado(){
		return $this->hasOne('App\Models\SubidaEliminada', 'id_subida', 'id_subida');
	}

}
