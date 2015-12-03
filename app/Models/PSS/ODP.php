<?php

namespace App\Models\PSS;

use Illuminate\Database\Eloquent\Model;

class ODP extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pss.codigos_odp';

	/**
	 * Devuelve el grupo etario
	 */
	public function grupoEtario(){
		return $this->hasOne('App\Models\PSS\GrupoEtario' , 'id_grupo_etario' , 'id_grupo_etario');
	}
}
