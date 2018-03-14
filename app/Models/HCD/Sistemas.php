<?php

namespace App\Models\HCD;

use Illuminate\Database\Eloquent\Model;

class Sistemas extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'hcd.sistemas';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_sistema';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Guardar el nombre del sistema.
     *
     * @param  string  $value
     * @return string
     */
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = mb_strtoupper($value);
    }

	/**
     * Get Nombre del sistema
     *
     * @param  string  $value
     * @return string
     */
    public function getNombreAttribute($value){
        return mb_strtoupper(html_entity_decode($value));
    }
}
