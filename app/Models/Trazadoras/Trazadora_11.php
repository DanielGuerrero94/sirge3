<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Trazadora_11 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.trz_11';

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
     * Devuelve la fecha de realizacion del TSOMF
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaAsistenciaTallerAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
