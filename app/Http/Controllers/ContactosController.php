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
            'contactos' => Usuario::with(['provincia' , 'conexion'])->orderBy('id_usuario')->get()
        ];
    	return view('contactos.main' , $data);
    }

    public function listado($nombre) {
        
        if ($nombre == 'ALL'){
            $contactos = Usuario::with(['provincia' , 'conexion'])->orderBy('id_usuario')->get();  
        } else {
            $contactos = Usuario::with(['provincia' , 'conexion'])->where('nombre' , 'ilike' , "%{$nombre}%")->orderBy('id_usuario')->get();
        }

        $data = ['contactos' => $contactos];
        return view('contactos.listado' , $data);
    }

    public function tarjeta($id){
        $data = ['usuario' => Usuario::with('provincia')->get()->find($id)];
        return view('contactos.tarjeta' , $data);
    }
}
