<?php

namespace App\Models\Dw;

use Illuminate\Database\Eloquent\Model;

class IndecPoblacionPais extends Model
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
	protected $table = 'indec.poblacion';
}
