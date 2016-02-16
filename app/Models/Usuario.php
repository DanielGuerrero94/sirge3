<?php

namespace App\Models;

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
	public $timestamps = true;

	/**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password', 'remember_token'];

    /**
     * Ingresar el nombre del usuario
     *
     * @param  string  $value
     * @return string
     */
    public function setNombreAttribute($value){
        $this->attributes['nombre'] = mb_strtoupper($value);
    }

    /**
     * Get the user's name.
     *
     * @param  string  $value
     * @return string
     */
    public function getNombreAttribute($value){
        return ucwords(mb_strtolower($value));
    }

    /**
     * Ingresar el email del usuario
     *
     * @param  string  $value
     * @return string
     */
    public function setEmailAttribute($value){
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * Ingresar el Facebook del usuario
     *
     * @param  string  $value
     * @return string
     */
    public function setFacebookAttribute($value){
        $this->attributes['facebook'] = strtolower($value);
    }

    /**
     * Ingresar el Twitter del usuario
     *
     * @param  string  $value
     * @return string
     */
    public function setTwitterAttribute($value){
        $this->attributes['twitter'] = strtolower($value);
    }

    /**
     * Ingresar el Linkedin del usuario
     *
     * @param  string  $value
     * @return string
     */
    public function setLinkedinAttribute($value){
        $this->attributes['linkedin'] = strtolower($value);
    }

    /**
     * Ingresar el Google del usuario
     *
     * @param  string  $value
     * @return string
     */
    public function setGoogleAttribute($value){
        $this->attributes['google'] = strtolower($value);
    }

    /**
     * Ingresar el Skype del usuario
     *
     * @param  string  $value
     * @return string
     */
    public function setSkypeAttribute($value){
        $this->attributes['skype'] = strtolower($value);
    }

	/**
	 * Obtener el menú asociado al usuario.
	 */
	public function menu() {
		return $this->hasOne('App\Models\Menu', 'id_menu', 'id_menu');
	}

	/**
	 * Obtener el área asociada al usuario.
	 */
	public function area() {
		return $this->hasOne('App\Models\Area', 'id_area', 'id_area');
	}

	/**
	 * Obtener la entidad asociada al usuario.
	 */
	public function provincia() {
		return $this->hasOne('App\Models\Geo\Provincia', 'id_provincia', 'id_provincia');
	}

	/**
	 * Obtener el sexo asociado al usuario.
	 */
	public function sexo() {
		return $this->hasOne('App\Models\Sexo', 'id_sexo', 'id_sexo');
	}

	/**
	 * Obtener conexiones
	 */
	public function conexiones() {
		return $this->hasMany('App\Models\Login' , 'id_usuario' , 'id_usuario');
	}

	/**
	 * Obtener la entidad
	 */
	public function entidad() {
		return $this->hasOne('App\Models\Entidad' , 'id' , 'id_entidad');
	}
}
