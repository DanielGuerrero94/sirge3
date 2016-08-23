<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Ppac extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.efectores_ppac';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_efector';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaAddendaPerinatalAttribute($value)
    {
        return $value === NULL ? $value : date('d/m/Y' , strtotime($value));
    }
}
