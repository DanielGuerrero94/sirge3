<?php
namespace App\Http\Controllers;
use App\Classes\Area;
use App\Http\Controllers\Controller;

class UsuarioController extends Controller {

	public function test() {

		$e = Area::find(1)->usuarios;
		echo '<pre>', print_r($e), '</pre>';
	}

}