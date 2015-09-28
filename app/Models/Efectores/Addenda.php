<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Addenda extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.efectores_addendas';

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
	public $timestamps = false;

	/**
	 * Devuelve el tipo de addenda
	 */
	public function tipo(){
		return $this->hasOne('App\Models\Efectores\Addendas\Tipo' , 'id' , 'id_addenda');
	}

	/**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaAddendaAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }
}
