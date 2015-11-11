<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PucoController extends Controller
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
	 * Devuelve la vista principal para generar el PUCO
	 *
	 * @return null
	 */
	public function getGenerar(){
		
	}
}
