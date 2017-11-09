<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Trazadora_1 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.trz_1';

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
     * Devuelve la fecha de control
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaControlAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Devuelve la fecha de la ultima menstruacion en el periodo
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaUltimaMenstruacionAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Devuelve la fecha probable de parto
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaProbablePartoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
