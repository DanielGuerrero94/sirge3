<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class LoteAceptado extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'sistema.lotes_aceptados';

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
	 * Obtener el lote dueño del lote aceptado
	 */
	public function lote() {
		return $this->belongsTo('App\Classes\Lote', 'lote', 'lote');
	}
}
