<?php

namespace App\Models\Beneficiarios;

use Illuminate\Database\Eloquent\Model;

class Resumen extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'beneficiarios.resumen_beneficiarios';

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
    protected $fillable = ['id_provincia','periodo','beneficiarios','beneficiarios_ceb','mujeres','mujeres_ceb','hombres','hombres_ceb','beneficiarios_05','beneficiarios_69','beneficiarios_1019','beneficiarios_2064'];	   
}
