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
	 * Calculo indicador 1 - NORMAL
	 *
	 * @return json	 
	 */
	public function getIndicadorUnoNormal(){
		$provincias = Provincia::find('05');

		foreach ($provincias as $provincia){
		}
		$numerador = DB::table('prestaciones')
					->where('codigo_prestacion' , '')
					->get();

		return json_encode($numerador);

	}
}
