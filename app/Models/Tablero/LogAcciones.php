<?php

namespace App\Models\Tablero;

use Illuminate\Database\Eloquent\Model;

class LogAcciones extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tablero.log_acciones';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	/**
	 * Devuelve la provincia
	 */
	public function provincias() {
		return $this->hasOne('App\Models\Geo\Provincia', 'id_provincia', 'id_provincia');
	}

	/**
	 * Devuelve la información del usuario
	 */
	public function usuario() {
		return $this->hasOne('App\Models\Usuario', 'id_usuario', 'id_usuario');
	}
}
