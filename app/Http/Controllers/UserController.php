<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;

class UserController extends Controller
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
     * Devuelve el listado de usuarios registrados
     *
     * @return view
     */
    public function index(){
    	$usuarios = Usuario::with('menu' , 'area' , 'provincia' , 'conexiones')->paginate(2);;
    	return view('admin.usuarios' , ['usuarios' => $usuarios]);
    }
}
