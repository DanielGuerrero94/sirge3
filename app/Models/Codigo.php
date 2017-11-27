<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pss.codigos';

    /**
     * Primary key asociated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'codigo_prestacion';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function tipoDePrestacion()
    {
        return $this->hasOne('App\Models\TipoPrestacion', 'tipo_prestacion', 'tipo');
    }
}
