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
     * Ingresar el nombre del modulo
     *
     * @param  string  $value
     * @return string
     */
    public function setDescripcionAttribute($value){
        $this->attributes['descripcion'] = mb_strtoupper($value);
    }

    /**
     * Ingresar la ruta del modulo
     *
     * @param  string  $value
     * @return string
     */
    public function setModuloAttribute($value){
        $this->attributes['modulo'] = strtolower($value);
    }

    /**
     * Ingresar el ícono del modulo
     *
     * @param  string  $value
     * @return string
     */
    public function setIconoAttribute($value){
        $this->attributes['icono'] = strtolower($value);
    }
	
}
