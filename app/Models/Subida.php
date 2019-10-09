<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subida extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.subidas';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_subida';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaSubidaAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getSizeAttribute($value)
    {
        return round(($value / 1024 / 1024) , 2) . ' mb';
    }

	/**
	 * Obtener el registro aceptado de la subida.
	 */
	public function aceptado(){
		return $this->hasOne('App\Models\SubidaAceptada', 'id_subida', 'id_subida');
	}

	/**
	 * Obtener el registro eliminado de la subida.
	 */
	public function eliminado(){
		return $this->hasOne('App\Models\SubidaEliminada', 'id_subida', 'id_subida');
	}

	/**
	 * Obtener el registro osp de la subida.
	 */
	public function obras(){
		return $this->hasOne('App\Models\SubidaOsp', 'id_subida', 'id_subida');
	}

	/**
	 * Setter del estado eliminado.
	 */
	public function setEstadoEliminado(){
        $this->id_estado = 4;
        $this->save();
	}



}
