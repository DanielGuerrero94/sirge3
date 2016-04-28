<?php

namespace App\Models\CA;

use Illuminate\Database\Eloquent\Model;

class MetaDatoReportable extends Model
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
	protected $table = 'compromiso_anual.metas_datos_reportables';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
