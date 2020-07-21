<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Diccionario;

class DiccionariosController extends Controller
{
	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
	}

	/**
	 * Devuelve el nombre del padron correspondiente
	 * @param int $id
	 *
	 * @return string
	 */
	protected function getNombrePadron($id){
		switch ($id) {
			case '1':	return 'PRESTACIONES';
			case 2: return 'APLICACIÓN DE FONDOS';
			case 3: return 'COMPROBANTES';
			case 4: return 'OBRA SOCIAL PROVINCIAL';
			case 5: return 'PROGRAMA FEDERAL DE SALUD';
			case 6: return 'SUPERINTENDENCIA DE SERVICIOS DE SALUD';
			default: break;
		}
	}

	/**
	 * Devuelve la vista principal
	 * @param int $id
	 *
	 * @return null
	 */	
	public function getDatadic($id){
		$data = [
			'page_title' => 'Diccionario de datos ' . $this->getNombrePadron($id),
			'padron' => $id
		];
		if ($id == 12) {
			$data['aclaraciones'] = "Aclaraciones";
		}
		return view('padrones.datadic' , $data);
	}

	/**
	 * Devuelve el JSON para la datatable
	 * @param int $id
	 *
	 * @return json
	 */
	public function getDatadicTabla($id){
		$campos = Diccionario::where('padron' , $id)->get();
		return Datatables::of($campos)->make(true);

	}

}
