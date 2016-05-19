<?php

namespace App\Models\Dw\CEB;

use Illuminate\Database\Eloquent\Model;

class Ceb003 extends Model
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
	protected $table = 'estadisticas.ceb_003 as c003';
}
