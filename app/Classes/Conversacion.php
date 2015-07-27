<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'chat.conversaciones';

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
	 * Obtener todos los mensajes de una conversacion
	 */
	public function mensajes(){
		return $this->hasMany('App\Classes\Mensaje' , 'id_conversacion' , 'id');
	}
    
}
