<?php

namespace App\Models\PUCO;

use Illuminate\Database\Eloquent\Model;

class Osp extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'puco.beneficiarios_osp';

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
	public $timestamps = false;
}
