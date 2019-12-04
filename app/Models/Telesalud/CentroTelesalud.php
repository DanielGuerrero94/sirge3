<?php

namespace App\Models\Telesalud;

use Illuminate\Database\Eloquent\Model;

class CentroTelesalud extends Model
{
    protected $connection = 'telesalud';
	protected $table = 'centro';
}
