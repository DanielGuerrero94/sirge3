<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'paises';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	//protected $primaryKey = 'id_area';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	public function posts(){
		return $this->hasManyThrough('App\Classes\Post' , 'App\Classes\User' , 'pais_id' , 'usuario_id');
	}

}
