<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	//protected $primaryKey = 'id_area';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	

}
