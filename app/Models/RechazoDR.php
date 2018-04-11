<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RechazoDR extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'logs.rechazosDR';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = true;

	protected $fillable = ['lote','registro','motivos'];

}
