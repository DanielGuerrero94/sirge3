<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profe extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'puco.profe';

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
     * Ingresar el nombre del beneficiario
     *
     * @param  string  $value
     * @return string
     */
    public function setNombreApellidoAttribute($value){
        $this->attributes['nombre_apellido'] = utf8_encode($value);
    }
}
