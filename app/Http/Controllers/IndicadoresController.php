<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;

class IndicadoresController extends Controller
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
	 * Devuelve la vista principal
	 *
	 * @return null
	 */
	public function getIndicadoresMedicaForm(){

		$provincias = Provincia::all();

		$data = [
			'page_title' => 'Indicadores médica',
			'provincias' => $provincias
		];
		return view('indicadores.provincia' , $data);
	}

	/**
	 * Devuelve la vista de los indicadores
	 * @param string $id
	 *
	 * @return null
	 */
	public function getIndicadoresMedica($id , $periodo){

		/**
		 *
		 * LOGICA Q LEVANTA LOS INDICADORES
		 *
		 */

		$data = [
			'page_title' => 'Indicadores médica : XXXXXXX'
		];
		return view('indicadores.medica' , $data);

	}

}
