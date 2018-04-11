<?php

namespace App\Models\Prestaciones;

use Illuminate\Database\Eloquent\Model;

class PrestacionDR extends Model
{
     /**
     * The table associated with the model.
	 *
	 * @var string
	 */
     protected $table = 'prestaciones.datos_reportables';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_dato_reportable';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
