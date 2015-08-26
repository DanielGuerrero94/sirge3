<?php

namespace App\Models\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'solicitudes.tipo_solicitud';

	/**
	 * Grupo
	 */
	public function grupos(){
		return $this->hasOne('App\Models\Solicitudes\Grupo' , 'id' , 'grupo');
	}
}
