<?php

namespace App\Models\Dw\DR;

use Illuminate\Database\Eloquent\Model;

class RevisionPrestacion extends Model
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
	protected $table = 'dr.revision_prestaciones';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_prestacion';

	public $fillable = ['id_prestacion', 'lote', 'validos', 'ausentes', 'errores'];
}
