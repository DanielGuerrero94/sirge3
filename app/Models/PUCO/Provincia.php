<?php

namespace App\Models\PUCO;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'puco.obras_sociales_provinciales';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'codigo_osp';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Devuelve el nombre de la OSP
	 */
	public function descripcion(){
		return $this->hasOne('App\Models\PUCO\ObraSocial' , 'codigo_osp' , 'codigo_osp');
	}
}
