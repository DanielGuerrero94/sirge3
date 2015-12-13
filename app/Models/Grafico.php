<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    /**
     * Devuelve los tags en un array
     *
     * @param  string  $value
     * @return json
     */
    public function getTagsAttribute($value)
    {
        return explode(',' , str_replace(['{','}'], '' , $value));
    }
}
