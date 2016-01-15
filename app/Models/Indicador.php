<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'indicadores.indicadores_medica';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Devuelve los limites verde,rojo,amarillo del indicador
	 */
	public function rangoIndicador()
	{
		return $this->hasOne('App\Models\Indicadores\MedicaRangos' , 'id_rango_indicador' , 'id_rango_indicador');	
	}
}
