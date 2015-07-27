<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model{
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'chat.mensajes';

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
