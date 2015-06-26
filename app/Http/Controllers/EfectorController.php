<?php namespace App\Http\Controllers;

use App\Classes\Efector;
use App\Http\Controllers\Controller;

class EfectorController extends Controller {

	public function test()
	{

		$efectores = Efector::find(1)->datosGeograficos;
		/*foreach ($efectores as $efector){
		echo '<pre>' , print_r($efector) , '</pre>';
		}*/
		echo $efectores;
	}

}