<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'geo.departamentos';

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
     * Nombre del departamento
     *
     * @param  string  $value
     * @return string
     */
    public function getNombreDepartamentoAttribute($value){
        return mb_strtoupper(html_entity_decode($value));
    }
}
