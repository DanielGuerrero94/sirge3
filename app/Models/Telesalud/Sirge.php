<?php

namespace App\Models\Telesalud;

use Illuminate\Database\Eloquent\Model;

class Sirge extends Model
{
    protected $connection = 'telesalud';
	protected $table = 'v_usuario_sirge';
}
