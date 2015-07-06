<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Sexo extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.sexos';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_sexo';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Obtener los usuarios asociados al sexo.
	 */
	public function usuarios() {
		return $this->belongsTo('App\Classes\Usuario', 'id_sexo', 'id_sexo');
	}
}
