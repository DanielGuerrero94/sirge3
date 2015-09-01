<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.menues';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_menu';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Ingresar la descripción del requerimiento
     *
     * @param  string  $value
     * @return string
     */
    public function setDescripcionAttribute($value){
        $this->attributes['descripcion'] = mb_strtoupper($value);
    }

	/**
	 * Obtener el usuario asociado al área.
	 */
	public function usuarios() {
		return $this->belongsToMany('App\Models\Usuario', 'id_menu', 'id_menu');
	}

	/**
	 * Obtener todos los módulos que pertenecen al menú
	 */
	public function relaciones() {
		return $this->hasMany('App\Models\ModuloMenu', 'id_menu', 'id_menu');
	}
}
