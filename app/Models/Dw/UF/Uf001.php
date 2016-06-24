<?php

namespace App\Models\Dw\Uf;

use Illuminate\Database\Eloquent\Model;

class Uf001 extends Model
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
	protected $table = 'estadisticas.uf_001';
}
