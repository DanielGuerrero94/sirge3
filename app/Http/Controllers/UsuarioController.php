<?php
namespace App\Http\Controllers;
use App\Classes\Usuario;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller {

	public function test() {

		$efectores = Usuario::find(1)->area;
		echo $efectores;
	}

}