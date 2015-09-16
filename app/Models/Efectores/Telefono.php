<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.telefonos';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_telefono';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['numero_telefono','id_tipo_telefono','observaciones'];

    /**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = mb_strtoupper($value);
    }
}
