<?php

namespace App\Models\Beneficiarios;

use Illuminate\Database\Eloquent\Model;

class Geografico extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'beneficiarios.geografico';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'clave_beneficiario';

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
    protected $fillable = ['clave_beneficiario','calle','numero','manzana','piso','calle_1','calle_2','barrio','municipio','id_departamento','id_localidad','id_provincia','codigo_postal'];	

    /**
	 * Guardar la calle del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setCalleAttribute($value)
	{
		$this->attributes['calle'] = mb_strtoupper($value);
	}

	/**
	 * Guardar manzana del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setManzanaAttribute($value)
	{
		$this->attributes['manzana'] = mb_strtoupper($value);
	}

	/**
	 * Guardar calle_1 del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setCalle1Attribute($value)
	{
		$this->attributes['calle_1'] = mb_strtoupper($value);
	}

	/**
	 * Guardar calle_2 del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setCalle2Attribute($value)
	{
		$this->attributes['calle_2'] = mb_strtoupper($value);
	}

	/**
	 * Guardar barrio del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setBarrioAttribute($value)
	{
		$this->attributes['barrio'] = mb_strtoupper($value);
	}

	/**
	 * Guardar municipio del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setMunicipioAttribute($value)
	{
		$this->attributes['municipio'] = mb_strtoupper($value);
	}

	/**
	 * Devuelve la provincia
	 */
	public function provincia(){
		return $this->hasOne('App\Models\Geo\Provincia' , 'id_provincia' , 'id_provincia');
	}

	/**
	 * Devuelve el departamento
	 */
	public function ndepartamento(){
		return $this->hasOne('App\Models\Geo\Departamento' , 'id' , 'id_departamento');
	}

	/**
	 * Devuelve la localidad
	 */
	public function localidad(){
		return $this->hasOne('App\Models\Geo\Localidad' , 'id' , 'id_localidad');
	}
}
