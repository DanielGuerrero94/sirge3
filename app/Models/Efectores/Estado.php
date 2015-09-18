<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.tipo_estado';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_estado';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Devolver la descripción
     *
     * @param  string  $value
     * @return string
     */
    public function getDescripcionAttribute($value){
        return (mb_strtoupper($value));
    }
}
