<?php

namespace App\Models\Trazadoras;

use Illuminate\Database\Eloquent\Model;

class Trazadora_10 extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trazadoras.trz_10';

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
}
