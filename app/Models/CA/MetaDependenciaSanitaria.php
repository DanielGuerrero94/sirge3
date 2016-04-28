<?php

namespace App\Models\CA;

use Illuminate\Database\Eloquent\Model;

class MetaDependenciaSanitaria extends Model
{
    /**
     * Definir la conexión de la bdd
     *
     * @var string
     */
    //protected $connection = 'datawarehouse';
    
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'compromiso_anual.metas_dependencias_sanitarias';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
