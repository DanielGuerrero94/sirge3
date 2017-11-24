<?php

namespace App\Models\CEI;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    /**
	 * The table associated with the model
	 *
	 * @var string
	 */
	protected $table = 'cei.grupos_etarios_cei';

/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
