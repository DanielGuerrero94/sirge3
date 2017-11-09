<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Trazadora_2 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.trz_2';

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
     * Devuelve la fecha probable de parto usada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaProbablePartoUsadaAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
