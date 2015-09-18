<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.tipo_categorizacion';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_categorizacion';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;
}
