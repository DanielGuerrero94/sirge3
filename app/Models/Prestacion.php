<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestacion extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'prestaciones.prestaciones';

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
	 * Devuelve los datos del efector asociado
	 */
	public function datosEfector()
	{
		return $this->hasOne('App\Models\Efector' , 'cuie' , 'efector');	
	}

	/**
	 * Devuelve los datos del código de prestacion
	 */
	public function datosPrestacion()
	{
		return $this->hasOne('App\Models\Codigo' , 'codigo_prestacion' , 'codigo_prestacion');	
	}	
}
