<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Login extends Model {
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'logs.logins';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_inicio';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
