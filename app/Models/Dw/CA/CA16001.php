<?php

namespace App\Models\Dw\CA;

use Illuminate\Database\Eloquent\Model;

class CA16001 extends Model
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
	protected $table = 'indicadores.ca_16_001';
}
