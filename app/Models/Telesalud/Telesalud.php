<?php

namespace App\Models\Telesalud;

use Illuminate\Database\Eloquent\Model;

class Telesalud extends Model
{
    protected $connection = 'telesalud';
	protected $table = 'v_consulta';
}
