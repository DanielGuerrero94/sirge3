<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Classes\Modulo;
use App\Classes\Menu;


class UsuarioController extends Controller {

	public function test() {

		
		$e = Menu::find(1)->modulos;
		echo '<pre>', print_r($e), '</pre>';
		/*
		foreach ($e as $key => $value) {
			echo $value->descripcion , '<br />';
		}
		*/

	}

}