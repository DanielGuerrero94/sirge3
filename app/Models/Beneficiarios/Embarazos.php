<?php

namespace App\Models\Beneficiarios;

use Illuminate\Database\Eloquent\Model;

class Embarazos extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'beneficiarios.beneficiarios_embarazos';

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
    protected $fillable = ['clave_beneficiario','fecha_diagnostico_embarazo','semanas_embarazo','fecha_probable_parto,fecha_efectiva_parto,fum,periodo'];	
    
}
