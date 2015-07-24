<?php

namespace App\Classes;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Usuario extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

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
	public function provincia() {
		return $this->hasOne('App\Classes\Provincia', 'id_provincia', 'id_provincia');
	}

	/**
	 * Obtener el sexo asociado al usuario.
	 */
	public function sexo() {
		return $this->hasOne('App\Classes\Sexo', 'id_sexo', 'id_sexo');
	}
}
