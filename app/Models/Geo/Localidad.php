<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'geo.localidades';

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
     * Nombre de la localidad
     *
     * @param  string  $value
     * @return string
     */
    public function getNombreLocalidadAttribute($value){
        return (mb_strtoupper($value));
    }
}

