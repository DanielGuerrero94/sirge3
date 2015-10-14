<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ComprobantesController extends Controller
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
	 * Procesa el archivo de comprobantes
	 *
	 * @return json
	 */
	public function postArchivo($id){
		return 'Archivo de comprobantes : ' . $id;
	}
}
