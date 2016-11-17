<?php

namespace App\Models\ODP;

use Illuminate\Database\Eloquent\Model;

class MetaDescripcion extends Model
{
    /**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'odp.meta_descripcion';

	/**
	 * Primary key asociated with the table.
	 *
	 * @var string
	 */
	protected $primaryKey = 'meta_desc_id';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
     * Mostrar la descripcion del componente.
     *
     * @param  string  $value
     * @return string
     */
    public function getDescripcionAttribute($value)
    {
        return mb_strtoupper(html_entity_decode($value));
    }
}
