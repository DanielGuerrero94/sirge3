<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\Usuario;
use App\Classes\Provincia;
use App\Classes\Entidad;
use App\Classes\Area;
use App\Classes\Menu;

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
    	$usuarios = Usuario::with('menu' , 'area' , 'provincia' , 'conexiones')->orderBy('nombre')->paginate(15);
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
     * @param int ID del usuario
     *
     * @return void
     */
    public function getEdit($id){
        $user = Usuario::find($id);
        $provincias = Provincia::all();
        $entidades = Entidad::all();
        $areas = Area::all();
        $menues = Menu::all();

        $data = [
            'usuario' => $user,
            'provincias' => $provincias,
            'entidades' => $entidades,
            'areas' => $areas,
            'menues' => $menues
        ];
        return view ('admin.usuarios-edit' , $data);
    }

    /**
     * Edita el usuario con los datos del formulario recibido
     * @param int ID del usuario
     * @param request Datos
     *
     * @return string
     */
    public function postEdit($id , Request $r){
        $usr = Usuario::find($id);
        $usr->nombre = $r->nombre;
        $usr->email = $r->email;
        $usr->id_provincia = $r->provincia;
        $usr->id_entidad = $r->entidad;
        $usr->id_menu = $r->menu;
        $usr->id_area = $r->area;
        if ($usr->save()){
            return 'Se ha modificado el usuario ' . $usr->nombre;
        }
    }

    /**
     * Acualiza el campo activo a "N" de un usuario por su ID
     * @param int ID del usuario
     *
     * @return string
     */
    public function postBaja($id){
        $u = Usuario::find($id);
        $u->activo = 'N';
        if ($u->save()){
            return 'Se ha bloqueado el acceso al usuario ' . $u->nombre;
        }
    }

    /**
     * Acualiza el campo activo a "S" de un usuario por su ID
     * @param int ID del usuario
     *
     * @return string
     */
    public function postUnblock($id){
        $u = Usuario::find($id);
        $u->activo = 'S';
        if ($u->save()){
            return 'Se desbloqueado el acceso al usuario ' . $u->nombre;
        }
    }
}

