<?php

namespace App\Models\Dw\DR;

use Illuminate\Database\Eloquent\Model;

class ResumenLote extends Model
{
        /**
	 * The connection name for the model.
	 *
	 * @var string
	 */
	protected $connection = 'datawarehouse';

 	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'dr.resumen_lotes';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'lote';

	public $fillable = ['lote','validos', 'ausentes', 'errores'];
}
