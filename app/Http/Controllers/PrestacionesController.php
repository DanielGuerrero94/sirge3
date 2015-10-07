<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PrestacionesController extends Controller
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
	public function getMain(){
		$data = [
			'page_title' => 'Prestaciones'
		];
		return view('padrones.main' , $data);
	}

}
