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
			'provincias' => Provincia::orderBy('id_provincia')->get()
		];

		return view('cei.resumen' , $data);
	}
}
