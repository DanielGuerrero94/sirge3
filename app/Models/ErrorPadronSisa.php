<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorPadronSisa extends Model
{
     /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'siisa.error_padron_siisa';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'numero_documento';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;	
}
