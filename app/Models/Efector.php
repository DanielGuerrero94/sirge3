<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Efector extends Model
{
    /**
	 * The table associated with the model
	 *
	 * @var string
	 */
	protected $table = 'efectores.efectores';

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
     * Guardar el nombre del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setNombreAttribute($value)
    {
        $this->attributes['nombre'] = mb_strtoupper($value);
    }

    /**
     * Guardar el domicilio del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setDomicilioAttribute($value)
    {
        $this->attributes['domicilio'] = mb_strtoupper($value);
    }

    /**
     * Guardar el codigo postal del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setCodigoPostalAttribute($value)
    {
        $this->attributes['codigo_postal'] = mb_strtoupper($value);
    }

    /**
     * Guardar la denominación legal del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setDenominacionLegalAttribute($value)
    {
        $this->attributes['denominacion_legal'] = mb_strtoupper($value);
    }

    /**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setDependenciaSanitariaAttribute($value)
    {
        $this->attributes['dependencia_sanitaria'] = mb_strtoupper($value);
    }

	/**
	 * Devuelvo el estado del efector
	 */
	public function estado(){
		return $this->hasOne('App\Models\Efectores\Estado' , 'id_estado' , 'id_estado');
	}

	/**
	 * Devuelvo la provincia del efector
	 */
	public function geo(){
		return $this->hasOne('App\Models\Efectores\Geografico' , 'id_efector' , 'id_efector');
	}

	/**
	 * Devuelvo el tipo de efector
	 */
	public function tipo(){
		return $this->hasOne('App\Models\Efectores\Tipo' , 'id_tipo_efector' , 'id_tipo_efector');
	}

	/**
	 * Devuelvo la categoría
	 */
	public function categoria(){
		return $this->hasOne('App\Models\Efectores\Categoria' , 'id_categorizacion' , 'id_categorizacion');
	}

	/**
	 * Devuelvo la dependencia administrativa
	 */
	public function dependencia(){
		return $this->hasOne('App\Models\Efectores\DependenciaAdministrativa' , 'id_dependencia_administrativa' , 'id_dependencia_administrativa');
	}

	/**
	 * Devuelvo el o los compromisos
	 */
	public function compromiso(){
		return $this->hasOne('App\Models\Efectores\Gestion' , 'id_efector' , 'id_efector');
	}

	/**
	 * Devuelvo el o los convenios
	 */
	public function convenio(){
		return $this->hasOne('App\Models\Efectores\Convenio' , 'id_efector' , 'id_efector');
	}

	/**
	 * Devuelvo los teléfonos
	 */
	public function telefonos(){
		return $this->hasMany('App\Models\Efectores\Telefono' , 'id_efector' , 'id_efector');
	}

	/**
	 * Devuelvo los emails
	 */
	public function emails(){
		return $this->hasMany('App\Models\Efectores\Email' , 'id_efector' , 'id_efector');
	}

	/**
	 * Devuelvo los referentes
	 */
	public function referentes(){
		return $this->hasMany('App\Models\Efectores\Referente' , 'id_efector' , 'id_efector');
	}

	/**
	 * Devuelve la descentralización
	 */
	public function internet(){
		return $this->hasOne('App\Models\Efectores\Descentralizacion' , 'id_efector' , 'id_efector');
	}
}
