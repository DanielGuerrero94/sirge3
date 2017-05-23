<?php

namespace App\Models\Solicitudes;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'solicitudes.adjuntos';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_adjunto';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

    /**
     * Devuelve el tamaño del archivo en MB
     *
     * @param  string  $value
     * @return string
     */
    public function getSizeSolicitanteAttribute($value)
    {
        return round(($value / 1024 / 1024) , 2) . ' mb';
    }

    /**
     * Devuelve el tamaño del archivo en MB
     *
     * @param  string  $value
     * @return string
     */
    public function getSizeRespuestaAttribute($value)
    {
        return round(($value / 1024 / 1024) , 2) . ' mb';
    }
}
