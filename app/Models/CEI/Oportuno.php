<?php

namespace App\Models\CEI;

use Illuminate\Database\Eloquent\Model;

class Oportuno extends Model
{
    /**
	 * The table associated with the model
	 *
	 * @var string
	 */
	protected $table = 'cei.indicadores_beneficiarios';

	/**
     * Devuelve los beneficiarios
     *
     * @param  string  $value
     * @return string
     */
    public function getBeneficiariosAttribute($value)
    {
        return json_decode($value);
    }
}
