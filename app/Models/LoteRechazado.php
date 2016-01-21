<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoteRechazado extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.lotes_rechazados';

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
	public $timestamps = true;

	/**
	 * Obtener el lote dueño del lote aceptado
	 */
	public function lote() {
		return $this->belongsTo('App\Models\Lote', 'lote', 'lote');
	}
}
