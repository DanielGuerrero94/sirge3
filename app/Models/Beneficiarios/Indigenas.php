<?php

namespace App\Models\Beneficiarios;

use Illuminate\Database\Eloquent\Model;

class Indigenas extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'beneficiarios.indigenas';

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
    protected $fillable = ['clave_beneficiario','declara_indigena','id_lengua','id_tribu'];	
}
