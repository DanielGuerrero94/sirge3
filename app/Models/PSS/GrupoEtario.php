<?php

namespace App\Models\PSS;

use Illuminate\Database\Eloquent\Model;

class GrupoEtario extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pss.grupos_etarios';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_grupo_etario';
}
