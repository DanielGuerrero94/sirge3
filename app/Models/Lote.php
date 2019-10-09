<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model 
{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.lotes';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'lote';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getInicioAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /* Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFinAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

	/**
	 * Obtener el lote aceptado asociado al lote
	 */
	public function loteAceptado() {
		return $this->hasOne('App\Models\LoteAceptado', 'lote', 'lote');
	}

	/**
	 * Devuelve el estado
	 */
	public function estado(){
		return $this->hasOne('App\Models\Estado' , 'id_estado' , 'id_estado');
	}

	/**
	 * Devuelve el listado de prestaciones rechazadas
	 */
	public function rechazos(){
		return $this->hasMany('App\Models\Rechazo' , 'lote' , 'lote');
	}

	/**
	 * Devuelve la información del archivo que generó el lote
	 */
	public function archivo(){
		return $this->belongsTo('App\Models\Subida' , 'id_subida' , 'id_subida');
	}

	/**
	 * Devuelve la información del usuario
	 */
	public function usuario(){
		return $this->hasOne('App\Models\Usuario' , 'id_usuario' , 'id_usuario');
	}

	/**
	 * Devuelve la información de la provincia
	 */
	public function provincia(){
		return $this->hasOne('App\Models\Geo\Provincia' , 'id_provincia' , 'id_provincia');
	}

	/**
	 * Setter del estado eliminado.
	 */
	public function setEstadoEliminado(){
        $this->id_estado = 4;
        $this->save();
	}

}
