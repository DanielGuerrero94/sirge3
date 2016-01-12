<?php

namespace App\Models\Dw\FC;

use Illuminate\Database\Eloquent\Model;

class Fc005 extends Model
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
	protected $table = 'estadisticas.fc_005';
}
