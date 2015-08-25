<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'solicitudes.solicitudes';

	/**
     * Ingresar la descripción del requerimiento
     *
     * @param  string  $value
     * @return string
     */
    public function setDescripcionSolicitudAttribute($value){
        $this->attributes['descripcion_solicitud'] = mb_strtoupper($value);
    }
}
