<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grafico extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'graficos.graficos';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Devuelve el título del grafico
     *
     * @param  string  $value
     * @return string
     */
    public function getTituloAttribute($value)
    {
        return mb_strtoupper($value);
    }

    /**
     * Devuelve la descripción del grafico
     *
     * @param  string  $value
     * @return string
     */
    public function getDescripcionAttribute($value)
    {
        return ucfirst(mb_strtolower($value));
    }
}
