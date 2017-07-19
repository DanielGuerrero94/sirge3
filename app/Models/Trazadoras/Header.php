<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'trazadoras.headers';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'lote';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
     * Devuelve la fecha de generacion
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaSuscripcionAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }
}
