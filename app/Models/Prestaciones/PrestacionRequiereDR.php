<?php

namespace App\Models\Prestaciones;

use Illuminate\Database\Eloquent\Model;

class PrestacionRequiereDR extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'prestaciones.requiere_datos_reportables';

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
