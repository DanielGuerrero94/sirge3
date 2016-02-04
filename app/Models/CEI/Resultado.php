<?php

namespace App\Models\CEI;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    /**
	 * The table associated with the model
	 *
	 * @var string
	 */
	protected $table = 'cei.resultados';

	/**
     * Devuelve el resultado
     *
     * @param  string  $value
     * @return string
     */
    public function getResultadosAttribute($value)
    {
        return json_decode($value);
    }
}
