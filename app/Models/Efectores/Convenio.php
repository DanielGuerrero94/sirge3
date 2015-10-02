<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Convenio extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.convenio_administrativo';

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
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['numero_convenio','numero_compromiso','firmante','fecha_suscripcion','fecha_inicio','fecha_fin','nombre_tercer_administrador','codigo_tercer_administrador'];

	/**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaSuscripcionAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaInicioAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Devuelve la fecha formateada
     *
     * @param  string  $value
     * @return string
     */
    public function getFechaFinAttribute($value)
    {
        return date('d/m/Y' , strtotime($value));
    }

    /**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setFirmanteAttribute($value)
    {
        $this->attributes['firmante'] = mb_strtoupper($value);
    }

    /**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setNombreTercerAdministradorAttribute($value)
    {
        $this->attributes['nombre_tercer_administrador'] = mb_strtoupper($value);
    }

    /**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setCodigoTercerAdministradorAttribute($value)
    {
        $this->attributes['codigo_tercer_administrador'] = mb_strtoupper($value);
    }


}
