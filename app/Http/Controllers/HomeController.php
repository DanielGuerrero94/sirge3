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
            return redirect()->intended('dashboard');
        } else {
            return redirect()->intended('login');
        }
    }
    
    protected function getMenu($id_menu){
        $menu = array();
        $relaciones = ModuloMenu::where('id_menu' , $id_menu)->get();
        foreach ($relaciones as $key => $relacion){
            $modulo = Modulo::find($relacion->id_modulo);
            $menu[$key]['descripcion'] = $modulo->descripcion;
            $menu[$key]['modulo'] = $modulo->modulo;
            $menu[$key]['nivel_1'] = $modulo->nivel_1;
            $menu[$key]['nivel_2'] = $modulo->nivel_2;
            $menu[$key]['icono'] = $modulo->icono;
            $menu[$key]['arbol'] = $modulo->arbol;
            $menu[$key]['id_padre'] = $modulo->id_padre;
            $menu[$key]['hijos'] = [];
        }
        return $this->armaArbol($menu);
    }

    protected function armaArbol($menu){
        foreach ($menu as $key => $modulo){
            if (! is_null($modulo['id_padre'])){
                $index = $modulo['id_padre'] - 1;
                array_push($menu[$index]['hijos'] , $modulo);
                unset ($menu[$key]);
            }
        }
        return $menu;
    }
    
    public function dashboard(){

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
        return view('dashboard' , $data);
    }
}
