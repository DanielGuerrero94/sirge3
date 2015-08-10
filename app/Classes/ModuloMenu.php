<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class ModuloMenu extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.modulos_menu';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_relacion';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;
        
    /**
     * Obtener el detalle de los módulos
     */
    public function modulos(){
        return $this->hasOne('App\Classes\Modulo', 'id_modulo', 'id_modulo');
    }
}
