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

	public function datosEfector()
	{
		return $this->hasOne('App\Models\Efector' , 'cuie' , 'efector');	
	}

	public function datosPrestacion()
	{
		return $this->hasOne('App\Models\Codigo' , 'codigo_prestacion' , 'codigo_prestacion');	
	}	
}
