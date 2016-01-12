<?php

namespace App\Models\Indicadores;

use Illuminate\Database\Eloquent\Model;

class MedicaRangos extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'indicadores.indicadores_medica_rangos';

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
	 * Devuelve la descripcion de codigo del indicador
	 */
	public function descripcionIndicador()
	{
		return $this->hasOne('App\Models\Indicadores\Descripcion' , 'indicador' , 'codigo_indicador');	
	}	
}
