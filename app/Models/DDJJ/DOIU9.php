<?php

namespace App\Models\DDJJ;

use Illuminate\Database\Eloquent\Model;

class DOIU9 extends Model
{
    /**
	 * The table associated with the model
	 *
	 * @var string
	 */
	protected $table = 'ddjj.doiu9';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_impresion';

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
    public function getFechaImpresionAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaCuentaCapitasAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaSirgeAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaReporteBimestralAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la provincia
     */
    public function provincia(){
        return $this->hasOne('App\Models\Geo\Provincia' , 'id_provincia' , 'id_provincia');
    }

}
