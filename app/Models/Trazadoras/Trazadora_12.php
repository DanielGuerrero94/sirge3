<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Trazadora_12 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.trz_12';

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
     * Devuelve la fecha de diagnostico histologico
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaDiagnosticoHistologicoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Devuelve la fecha de inicio del tratamiento
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaInicioTratamientoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
