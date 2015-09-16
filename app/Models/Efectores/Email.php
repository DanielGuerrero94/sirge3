<?php

namespace App\Models\Efectores;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'efectores.email';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'id_email';

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
    protected $fillable = ['email','observaciones'];

    /**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    /**
     * Guardar la dependencia sanitaria del efector.
     *
     * @param  string  $value
     * @return string
     */
    public function setObservacionesAttribute($value)
    {
        $this->attributes['observaciones'] = mb_strtoupper($value);
    }
}
