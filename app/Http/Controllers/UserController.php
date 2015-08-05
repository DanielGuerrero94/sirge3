<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;
use App\Classes\Provincia;
use App\Classes\Entidad;

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
    public function index(Request $r){
    	$usuarios = Usuario::with('menu' , 'area' , 'provincia' , 'conexiones')->paginate(15);;
    	$usuarios->setPath('usuarios');
    	$data = [
    		'page_title' => 'ABM Usuarios',
    		'usuarios' => $usuarios
    	];

    	if (sizeof($r->query())){
    		return view('admin.usuarios-table' , $data);
    	} else {
    		return view('admin.usuarios' , $data);
    	}
    }

    /**
     * Devuelve la vista para editar un usuario
     * @param int Id del usuario
     *
     * @return void
     */
    public function edit($id){
        $user = Usuario::find($id);
        $provincias = Provincia::all();
        $entidades = Entidad::all();

        $data = [
            'usuario' => $user,
            'provincias' => $provincias,
            'entidades' => $entidades
        ];
        return view ('admin.usuarios-edit' , $data);
    }
}
