<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rechazo extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'logs.rechazos';

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
	public $timestamps = true;

	/**
     * Devuelve el registro rechazado formateado
     *
     * @param  string  $value
     * @return string
     */
    public function getRegistroAttribute($value)
    {
        // return implode(';' , json_decode($value , TRUE));
    }
}
