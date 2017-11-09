<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Trazadora_14 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.trz_14';

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
     * Devuelve la fecha de defuncion
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaDefuncionAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Devuelve la fecha de auditoria de muerte
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaAuditoriaMuerteAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * Devuelve la fecha de parto o interrupcion embarazo
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaPartoOInterrupcionEmbarazoAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
