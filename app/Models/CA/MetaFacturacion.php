<?php

namespace App\Models\CA;

use Illuminate\Database\Eloquent\Model;

class MetaFacturacion extends Model
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
	protected $table = 'compromiso_anual.metas_facturacion';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
