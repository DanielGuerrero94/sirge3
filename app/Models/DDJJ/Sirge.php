<?php

namespace App\Models\DDJJ;

use Illuminate\Database\Eloquent\Model;

class Sirge extends Model
{
	/**
	 * The table associated with the model
	 *
	 * @var string
	 */
	protected $table = 'ddjj.sirge';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_impresion';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaAceptadoAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }
}
