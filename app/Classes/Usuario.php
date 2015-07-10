<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.usuarios';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_usuario';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Obtener el menú asociado al usuario.
	 */
	public function menu() {
		return $this->hasOne('App\Classes\Menu', 'id_menu', 'id_menu');
	}

	/**
	 * Obtener el área asociada al usuario.
	 */
	public function area() {
		return $this->hasOne('App\Classes\Area', 'id_area', 'id_area');
	}

	/**
	 * Obtener la entidad asociada al usuario.
	 */
	public function entidad() {
		return $this->hasOne('App\Classes\Entidad', 'id_provincia', 'id_provincia');
	}

	/**
	 * Obtener el sexo asociado al usuario.
	 */
	public function sexo() {
		return $this->hasOne('App\Classes\Sexo', 'id_sexo', 'id_sexo');
	}
}
