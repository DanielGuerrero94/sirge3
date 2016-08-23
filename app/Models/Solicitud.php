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

    public $timestamps = true;

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
     * Ingresar la descripción de la solución
     *
     * @param  string  $value
     * @return string
     */
    public function setDescripcionSolucionAttribute($value){
        $this->attributes['descripcion_solucion'] = mb_strtoupper($value);
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaSolicitudAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaEstimadaSolucionAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaAsignacionAttribute($value)
    {
        return $value === NULL ? $value : date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaSolucionAttribute($value)
    {
        return $value === NULL ? $value : date('d/m/Y' , strtotime($value));
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
     * Usuario
     */
    public function usuario(){
        return $this->hasOne('App\Models\Usuario' , 'id_usuario' , 'usuario_solicitante');
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