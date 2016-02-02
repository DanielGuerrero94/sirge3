<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Mail;
use Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Prestacion;
use App\Models\Geo\Provincia;

use App\Models\CEI\Grupo;
use App\Models\CEI\Linea;

class CeiController extends Controller
{
    /**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
		setlocale(LC_TIME, 'es_ES.UTF-8');
	}

	/**
	 * Devuelve la vista para el Resumen mensual
	 * 
	 * @return null
	 */
	public function getResumen(){

		$data = [
			'page_title' => 'Resumen C.E.I.',
			'provincias' => Provincia::orderBy('id_provincia')->get(),
			'grupos' => Grupo::all()
		];

		return view('cei.filtros' , $data);
	}

	/**
	 * Devuelve las lineas de cuidado asociadas a un grupo etario
	 * @param int $grupo
	 * 
	 * @return null
	 */
	public function getLineas($grupo){
		$lineas = Linea::where('grupo_etario' , $grupo)->get();
		return response()->json($lineas);
	}
}
