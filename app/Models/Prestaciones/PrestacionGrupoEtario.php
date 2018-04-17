<?php

namespace App\Models\Prestaciones;

use Illuminate\Database\Eloquent\Model;

class PrestacionGrupoEtario extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'prestaciones.grupos_etarios';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_grupo_etario';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
