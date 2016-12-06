<?php

namespace App\Models\ODP;

use Illuminate\Database\Eloquent\Model;

class MetaResultado extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'odp.meta_resultado';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * [Elijo las columnas que pueden utilizarse via Mass Asignment]
	 * @var [type]
	 */
	protected $fillable = ['id_tipo_meta', 'detalle', 'provincia', 'year'];

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */		
	public $timestamps = false;

	/**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'detalle' => 'array'
    ];
}
