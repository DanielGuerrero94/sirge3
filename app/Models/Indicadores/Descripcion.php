<?php

namespace App\Models\Indicadores;

use Illuminate\Database\Eloquent\Model;

class Descripcion extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'indicadores.indicadores_descripcion';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'indicador';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Mostrar la descripcion del indicador.
     *
     * @param  string  $value
     * @return string
     */
    public function getDescripcionAttribute($value)
    {
        return mb_strtoupper(html_entity_decode($value));
    }
}
