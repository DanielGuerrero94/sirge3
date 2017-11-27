<?php

namespace App\Models\PSS;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'pss.codigos_grupos';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'codigo_prestacion';

	/**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $timestamps = false;

	/**
	 * Devuelve el grupo etario
	 */
	public function grupoEtario(){
		return $this->hasOne('App\Models\PSS\GrupoEtario' , 'id_grupo_etario' , 'id_grupo_etario');
	}

	/**
	 * Devuelve la linea de cuidado
	 */
	public function lineaCuidado(){
		return $this->hasOne('App\Models\PSS\LineaCuidado' , 'id_linea_cuidado' , 'id_linea_cuidado');
	}

	/**
	 * Devuelve la prestacion
	 */
	public function prestacion(){
		return $this->hasOne('App\Models\Prestacion' , 'codigo_prestacion' , 'codigo_prestacion');
	}
}
