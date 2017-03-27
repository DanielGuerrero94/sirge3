<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscriptosPadronSisa extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'siisa.inscriptos_padron';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'nrodocumento';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;	
}
