<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salud extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pss.codigos';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'codigo_prestacion';

	/**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
	
	/**
	 * Codigos grupos
	 */
	public function grupo(){
		return $this->hasMany('App\Models\PSS\Grupo' , 'codigo_prestacion' , 'codigo_prestacion');
	}

	/**
	 * Devuelve CEB
	 */
	public function ceb(){
		return $this->hasMany('App\Models\PSS\CEB' , 'codigo_prestacion' , 'codigo_prestacion');
	}

	/**
	 * Devuelve los ODP
	 */
	public function odp(){
		return $this->hasMany('App\Models\PSS\ODP' , 'codigo_prestacion' , 'codigo_prestacion');
	}

	/**
	 * Devuelve trazadoras
	 */
	public function trazadora(){
		return $this->hasMany('App\Models\PSS\Trazadora' , 'codigo_prestacion' , 'codigo_prestacion');
	}

	/**
	 * Devuelve las prestaciones con ese codigo
	 */
	public function tipoDePrestacion()
	{
		return $this->hasOne('App\Models\TipoPrestacion' , 'tipo_prestacion' , 'tipo');	
	}
}
