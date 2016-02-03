<?php

namespace App\Models\Dw\FC;

use Illuminate\Database\Eloquent\Model;

class Fc008 extends Model
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
    protected $table = 'estadisticas.fc_008';

    /**
	 * Devuelve la prestacion
	 */
	public function prestacion(){
		return $this->hasOne('App\Models\Salud' , 'codigo_prestacion' , 'codigo_prestacion');
	}
}
