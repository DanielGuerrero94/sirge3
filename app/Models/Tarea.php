<?php

namespace App\\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
     /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'scheduler.tareas';

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
	public $timestamps = true;	
}
