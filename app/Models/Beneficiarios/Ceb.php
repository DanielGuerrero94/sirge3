<?php

namespace App\Models\Beneficiarios;

use Illuminate\Database\Eloquent\Model;

class Ceb extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'beneficiarios.beneficiarios_ceb';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	//protected $primaryKey = 'clave_beneficiario';

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
    protected $fillable = ['clave_beneficiario','periodo','efector','fecha_ultima_prestacion','codigo_prestacion','devenga_capita','devenga_cantidad_capita'];	

    /**
	 * Guardar el cuie del efector
	 *
	 * @param  string  $value
     * @return string
	 */
	public function setEfectorAttribute($value)
	{
		$this->attributes['efector'] = mb_strtoupper($value);
	}

	/**
	 * Devuelve el efector
	 */
	public function datosEfector()
	{
		return $this->hasOne('App\Models\Efector' , 'efector' , 'cuie');
	}
}
