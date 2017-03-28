<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenerarRechazoLote extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'scheduler.generacion_rechazos_padrones';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'lote';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

}
