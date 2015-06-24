<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class EfectorGeografico extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'efectores.datos_geograficos';

    /**
     * Table primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id_efector';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
