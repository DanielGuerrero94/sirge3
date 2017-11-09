<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.beneficiarios';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'numero_documento';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Devuelve la fecha de nacimiento
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaNacimientoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
