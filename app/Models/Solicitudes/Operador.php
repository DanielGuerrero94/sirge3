<?php

namespace App\Models\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'solicitudes.operadores';

	/**
     * Operador
     */
    public function usuario(){
        return $this->hasOne('App\Models\Usuario' , 'id_usuario' , 'id_usuario');
    }

    /**
     * Grupo
     */
    public function sector(){
    	return $this->hasOne('App\Models\Solicitudes\Grupo' , 'id' , 'id_grupo');
    }
}
