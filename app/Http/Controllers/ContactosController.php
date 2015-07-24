<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;
use App\Classes\Provincia;

class ContactosController extends Controller
{
	/**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(){
        $data = [
            'page_title' => 'Contactos SUMAR',
            'contactos' => Usuario::with('provincia')->get()
        ];
    	return view('contactos.listado' , $data);
    }

    public function tarjeta($id){
        $data = [
            'usuario' => Usuario::with('provincia')->get()->find($id)
        ];
        return view('contactos.tarjeta' , $data);
    }
}
