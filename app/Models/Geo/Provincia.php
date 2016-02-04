<?php

namespace App\Models\Geo;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'geo.provincias';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_provincia';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
     * Nombre de la provincia
     *
     * @param  string  $value
     * @return string
     */
    public function getDescripcionAttribute($value){
        return mb_strtoupper($value);
    }
}
