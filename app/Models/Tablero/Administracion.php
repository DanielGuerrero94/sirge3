<?php

namespace App\Models\Tablero;

use Illuminate\Database\Eloquent\Model;

class Administracion extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'tablero.administracion';

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
		return $this->hasOne('App\Models\Geo\Provincia', 'id_provincia', 'provincia');
	}

	/**
	 * Devuelve el estado
	 */
	public function estados() {
		return $this->hasOne('App\Models\Estado', 'id_estado', 'estado');
	}

	/**
	 * Devuelve la información del usuario
	 */
	public function usuario() {
		return $this->hasOne('App\Models\Usuario', 'id_usuario', 'usuario_accion');
	}
}
