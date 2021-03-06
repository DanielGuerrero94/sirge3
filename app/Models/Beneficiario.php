<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiario extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'beneficiarios.beneficiarios';

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
	 * Guardar el nombre del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setNombreAttribute($value)
	{
		$this->attributes['nombre'] = mb_strtoupper($value);
	}

	/**
	 * Guardar el apellido del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setApellidoAttribute($value)
	{
		$this->attributes['apellido'] = mb_strtoupper($value);
	}

	/**
	 * Guardar el nombre del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setPaisAttribute($value)
	{
		$this->attributes['pais'] = mb_strtoupper($value);
	}

	/**
	 * Guardar el nombre del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setObservacionesAttribute($value)
	{
		$this->attributes['observaciones'] = mb_strtoupper($value);
	}

	/**
	 * Devuelve la fecha de nacimiento
	 *
	 * @param  string  $value
     * @return string
	 */
	public function getFechaNacimientoAttribute($value)
	{
		return date('d/m/Y' , strtotime($value));
	}

	/**
	 * Devuelve la fecha de inscripcion
	 *
	 * @param  string  $value
     * @return string
	 */
	public function getFechaInscripcionAttribute($value)
	{
		return date('d/m/Y' , strtotime($value));
	}

	/**
	 * Devuelve el tipo de documento
	 */
	public function documento()
	{
		return $this->hasOne('App\Models\TipoDocumento' , 'id_tipo_documento' , 'tipo_documento');
	}

	/**
	 * Devuelve los datos geograficos
	 */
	public function geo()
	{
		return $this->hasOne('App\Models\Beneficiarios\Geografico' , 'clave_beneficiario' , 'clave_beneficiario');
	}


	/**
	 * Devuelve la clase del documento
	 */
	public function claseDocumento()
	{
		return $this->hasOne('App\Models\ClaseDocumento' , 'clase_documento' , 'clase_documento');	
	}

	/**
	 * Devuelve el grupo etario
	 */
	public function grupo()
	{
		return $this->hasOne('App\Models\Pss\GrupoEtario' , 'id_grupo_etario' , 'grupo_actual');	
	}

	/**
	 * Devuelve las prestaciones asociadas al beneficiario
	 */
	public function susPrestaciones()
	{
		return $this->hasMany('App\Models\Prestacion' , 'clave_beneficiario' , 'clave_beneficiario');	
	}


}
