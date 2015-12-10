<?php

namespace App\Models\CA;

use Illuminate\Database\Eloquent\Model;

class MetaDescentralizacion extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'compromiso_anual.metas_descentralizacion';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
