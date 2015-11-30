<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Neonatal extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.efectores_neonatales';

	/**
	 * Devuelve el tipo
	 */
	public function info(){
		return $this->hasOne('App\Models\Efectores\CategoriaPPAC' , 'id_categoria' , 'id_categoria');
	}
}
