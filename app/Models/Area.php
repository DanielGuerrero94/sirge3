<?php

namespace App\Models;

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
	public $timestamps = false;

	/**
	 * Obtener los usuarios asociados al área
	 */
	public function usuarios() {
		return $this->hasMany('App\Models\Usuario', 'id_area', 'id_area');
	}
}
