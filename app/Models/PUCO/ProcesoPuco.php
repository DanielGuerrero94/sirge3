<?php

namespace App\Models\PUCO;

use Illuminate\Database\Eloquent\Model;

class ProcesoPuco extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'puco.procesos_obras_sociales';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'lote';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Retorna el lote asociado
	 */
	public function lotes(){
		return $this->hasOne('App\Models\Lote' , 'lote' , 'lote');
	}
}
