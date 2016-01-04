<?php

namespace App\Models\Beneficiarios;

use Illuminate\Database\Eloquent\Model;

class Parientes extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'beneficiarios.parientes';

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
    protected $fillable = ['clave_beneficiario','madre_tipo_documento','madre_numero_documento','madre_apellido',
  'madre_nombre', 
  'padre_tipo_documento',
  'padre_numero_documento', 
  'padre_apellido', 
  'padre_nombre', 
  'otro_tipo_documento', 
  'otro_numero_documento',
  'otro_apellido',
  'otro_nombre', 
  'otro_tipo_relacion'];	

    /**
	 * Guardar madre_apellido del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setMadreApellidoAttribute($value)
	{
		$this->attributes['madre_apellido'] = mb_strtoupper($value);
	}

	/**
	 * Guardar madre_nombre del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setMadreNombreAttribute($value)
	{
		$this->attributes['madre_nombre'] = mb_strtoupper($value);
	}

	/**
	 * Guardar padre_apellido del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setPadreApellidoAttribute($value)
	{
		$this->attributes['padre_apellido'] = mb_strtoupper($value);
	}

	/**
	 * Guardar padre_nombre del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setPadreNombreAttribute($value)
	{
		$this->attributes['padre_nombre'] = mb_strtoupper($value);
	}

	/**
	 * Guardar otro_apellido del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setOtroApellidoAttribute($value)
	{
		$this->attributes['otro_apellido'] = mb_strtoupper($value);
	}

	/**
	 * Guardar otro_nombre del beneficiario
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setOtroNombreAttribute($value)
	{
		$this->attributes['otro_nombre'] = mb_strtoupper($value);
	}

}
