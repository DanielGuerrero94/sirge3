<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class DependenciaAdministrativa extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.tipo_dependencia_administrativa';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_dependencia_administrativa';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
