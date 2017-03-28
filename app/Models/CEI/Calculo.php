<?php

namespace App\Models\CEI;

use Illuminate\Database\Eloquent\Model;

class Calculo extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cei.indicadores_calculo';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Devuelve el numerador
     *
     * @param  string  $value
     * @return string
     */
    public function getNumeradorAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Devuelve el denominador
     *
     * @param  string  $value
     * @return string
     */
    public function getDenominadorAttribute($value)
    {
        return json_decode($value);
    }
}
