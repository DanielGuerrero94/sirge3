<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.entidades';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
