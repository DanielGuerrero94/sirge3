<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Efector extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'efectores.efectores';

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

    /**
     * Get the phone record associated with the user.
     */
    public function datosGeograficos()
    {
        return $this->hasOne('App\Classes\EfectorGeografico' , 'id_efector');
    }
}
