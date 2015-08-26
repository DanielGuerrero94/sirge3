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

    /**
     * Tipo de solicitud
     */
    public function tipos(){
        return $this->hasOne('App\Models\Solicitudes\Tipo' , 'id' , 'tipo');
    }

    /**
     * Estado
     */
    public function estados(){
        return $this->hasOne('App\Models\Solicitudes\Estado' , 'id' , 'estado');
    }

    /**
     * Operador
     */
    public function operador(){
        return $this->hasOne('App\Models\Usuario' , 'id_usuario' , 'usuario_asignacion');
    }

    /**
     * Prioridad
     */
    public function prioridades(){
        return $this->hasOne('App\Models\Solicitudes\Prioridad' , 'id' , 'prioridad');
    }
}