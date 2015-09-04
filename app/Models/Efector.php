<?php

namespace App\Models;

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
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_efector';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Busco el estado del efector
	 */
	public function estado(){
		return $this->hasOne('App\Models\Efectores\Estado' , 'id_estado' , 'id_estado');
	}

}
