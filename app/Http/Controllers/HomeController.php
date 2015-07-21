<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Classes\ModuloMenu;
use App\Classes\Modulo;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(){
    	if (Auth::check()){
            return redirect()->intended('inicio');
        } else {
            return redirect()->intended('login');
        }
    }
    
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
    
    public function inicio(){

        if (! Auth::check()){
            return redirect()->intended('login');
        }

        $data = [
            'page_title' => 'Dashboard',
            'usuario' => Auth::user()->nombre,
            'ocupacion' => 'Desarrollador PHP',
            'alta' => 'Oct. 2012',
            'modulos' => $this->getMenu(Auth::user()->id_menu)
        ];
        return view('inicio' , $data);
    }

    public function dashboard(){
        return view ('dashboard');
    }
}
