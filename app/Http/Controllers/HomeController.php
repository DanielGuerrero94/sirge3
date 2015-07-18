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
            return redirect()->intended('/dashboard');
        } else {
            return redirect()->intended('/login');            
        }
    }
    
    protected function getMenu($id_menu){
        $menu = array();
        $i = 0;
        $relaciones = ModuloMenu::where('id_menu' , $id_menu)->get();
        foreach ($relaciones as $key => $relacion){
            $modulo = Modulo::find($relacion->id_modulo);
            $menu[$i]['descripcion'] = $modulo->descripcion;
            $menu[$i]['modulo'] = $modulo->modulo;
            $menu[$i]['nivel_1'] = $modulo->nivel_1;
            $menu[$i]['nivel_2'] = $modulo->nivel_2;
            $menu[$i]['icono'] = $modulo->icono;
            $menu[$i]['arbol'] = $modulo->arbol;
            $i++;
        }
        return $menu;
    }
    
    public function dashboard(){
        $data = [
            'page_title' => 'Dashboard',
            'usuario' => Auth::user()->nombre,
            'ocupacion' => 'Desarrollador PHP',
            'alta' => 'Oct. 2012',
            'modulos' => $this->getMenu(Auth::user()->id_menu)
        ];
        //return view('dashboard' , $data);
        echo '<pre>' , print_r($this->getMenu(Auth::user()->id_menu)) , '</pre>';
    }
}
