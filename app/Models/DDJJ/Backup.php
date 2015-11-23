<?php

namespace App\Models\DDJJ;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    /**
	 * The table associated with the model
	 *
	 * @var string
	 */
	protected $table = 'ddjj.backup';

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
    public function getFechaBackupAttribute($value)
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
