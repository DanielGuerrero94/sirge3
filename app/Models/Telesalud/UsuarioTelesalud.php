<?php

namespace App\Models\Telesalud;

use Illuminate\Database\Eloquent\Model;

class UsuarioTelesalud extends Model
{
    protected $connection = 'telesalud';
	protected $table = 'usuario';
}
