<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.areas';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_area';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Obtener los usuarios asociados al área
	 */
	public function usuarios() {
		return $this->belongsTo('App\Classes\Usuario' 'id_area' , 'id_area');
	}
}
