<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.lotes';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'lote';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Obtener el lote aceptado asociado al lote
	 */
	public function loteAceptado() {
		return $this->hasOne('App\Models\LoteAceptado', 'lote', 'lote');
	}
}
