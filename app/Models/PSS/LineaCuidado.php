<?php

namespace App\Models\PSS;

use Illuminate\Database\Eloquent\Model;

class LineaCuidado extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pss.lineas_cuidado';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_linea_cuidado';
}
