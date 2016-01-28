<?php

namespace App\Models\Dw\FC;

use Illuminate\Database\Eloquent\Model;

class Fc006 extends Model
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
    protected $table = 'estadisticas.fc_006';

    /**
	 * Devuelve la prestacion
	 */
	public function prestacion(){
		return $this->hasOne('App\Models\Prestacion' , 'codigo_prestacion' , 'codigo_prestacion');
	}
}
