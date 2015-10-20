<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestacion extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'prestaciones.prestaciones';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_prestacion';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
