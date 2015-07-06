<?php
namespace App\Http\Controllers;
use App\Classes\Usuario;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller {

	public function test() {

		$e = Usuario::find(1)->area->nombre;
		echo '<pre>', print_r($e), '</pre>';
	}

}