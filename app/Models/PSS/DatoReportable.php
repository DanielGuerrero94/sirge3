<?php

namespace App\Models\PSS;

use Illuminate\Database\Eloquent\Model;

class DatoReportable extends Model
{
    /**
     * Definir la conexión de la bdd
     *
     * @var string
     */
    protected $connection = 'datawarehouse';

    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pss.codigos_datos_reportables';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'codigo_prestacion';

	/**
	 * Devuelve los datos del código de prestacion
	 */
	public function prestacion()
	{
		return $this->hasOne('App\Models\Salud' , 'codigo_prestacion' , 'codigo_prestacion');	
	}	
}
