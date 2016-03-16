<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Geografico extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.datos_geograficos';

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
	public $timestamps = true;

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_provincia','id_departamento','id_localidad','ciudad'];

	/**
	 * Devuelve la provincia
	 */
	public function provincia(){
		return $this->hasOne('App\Models\Geo\Provincia' , 'id_provincia' , 'id_provincia');
	}

	/**
	 * Devuelve el departamento
	 */
	public function departamento(){
		return $this->hasOne('App\Models\Geo\Departamento' , 'id' , 'id_departamento');
	}

	/**
	 * Devuelve la localidad
	 */
	public function localidad(){
		return $this->hasOne('App\Models\Geo\Localidad' , 'id' , 'id_localidad');
	}

	/**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setCiudadAttribute($value)
    {
        $this->attributes['ciudad'] = mb_strtoupper($value);
    }

}
