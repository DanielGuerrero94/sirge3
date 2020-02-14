<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Datos extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.datos_efector';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_datos_efector';

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
    protected $fillable = ['cuie', 'categoria_maternidad', 'cumple_cone', 'categoria_neonatologia', 'opera_malformaciones', 'categoria_cc', 'categoria_iam', 'red_flap'];

}
