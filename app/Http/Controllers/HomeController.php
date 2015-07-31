<?php

namespace App\Http\Controllers;
use Auth;
use Mail;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\ModuloMenu;
use App\Classes\Modulo;
use App\Classes\Usuario;

class HomeController extends Controller
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
     * Vista principal en caso de no ingresar login o inicio
     */
    public function index(){
    	return redirect()->intended('inicio');
    }
    
    /**
     * Armado de menú
     */
    protected function getMenu($id_menu){
        $menu = array();
        $relaciones = ModuloMenu::where('id_menu' , $id_menu)->get();
        foreach ($relaciones as $key => $relacion){
            $modulo = Modulo::find($relacion->id_modulo);
            $menu[$modulo->id_modulo]['descripcion'] = $modulo->descripcion;
            $menu[$modulo->id_modulo]['modulo'] = $modulo->modulo;
            $menu[$modulo->id_modulo]['nivel_1'] = $modulo->nivel_1;
            $menu[$modulo->id_modulo]['nivel_2'] = $modulo->nivel_2;
            $menu[$modulo->id_modulo]['icono'] = $modulo->icono;
            $menu[$modulo->id_modulo]['arbol'] = $modulo->arbol;
            $menu[$modulo->id_modulo]['id_padre'] = $modulo->id_padre;
            $menu[$modulo->id_modulo]['hijos'] = [];
        }
        return $this->armaArbol($menu);
    }

    /**
     * Armo árbol con módulos
     */
    protected function armaArbol($menu){
        foreach ($menu as $key => $modulo){
            if ($modulo['id_padre']){
                $index = $modulo['id_padre'];
                array_push($menu[$index]['hijos'] , $modulo);
                unset ($menu[$key]);
            }
        }
        return $menu;
    }
    
    /**
     * Retorna vista principal
     */
    public function inicio(){

        $user = Usuario::findOrFail(8);
        $data = [
            'usuario' => Auth::user()->nombre,
            'ocupacion' => 'Desarrollador PHP',
            'alta' => 'Oct. 2012',
            'modulos' => $this->getMenu(Auth::user()->id_menu)
        ];
        return view('inicio' , $data);
    }

    /**
     * Retorna vista dashboard
     */
    public function dashboard(){
        $data = [
            'page_title' => 'Dashboard'
        ];
        return view ('dashboard' , $data);
    }
}
