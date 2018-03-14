<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Trazadora_6 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.trz_6';

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
     * Devuelve la fecha de diagnostico
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaDiagnosticoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Devuelve la fecha de denuncia
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaDenunciaAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
