<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Classes\Menu;
use App\Classes\Modulo;

class UsuarioController extends Controller {

	public function test() {
		
		$modulos = Menu::find(1)->modulos;
		foreach ($modulos as $key => $modulo) {
			$info = Modulo::find($modulo->id_modulo);
			echo $info->descripcion;
		}
	}
}