<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Menu;
use App\Classes\Modulo;
use App\Classes\ModuloMenu;

class MenuesController extends Controller
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
     * Devuelve el listado de menues
     * @param Request
     * 
     * @return null
     */
    public function index(Request $r){
    	$menues = Menu::orderBy('id_menu')->paginate(15);
    	$menues->setPath('menues');
    	$data = [
    		'page_title' => 'ABM Menues',
    		'menues' => $menues
    	];

    	if (sizeof($r->query())){
    		return view('admin.menues.table' , $data);
    	} else {
    		return view('admin.menues.menues' , $data);
    	}
    }

    /**
     * Devuelve la vista para editar un menú
     * @param int ID del area
     *
     * @return null
     */
    public function getEdit($id){
        $menu = Menu::find($id);
        $data = [
            'menu' => $menu,
        ];
        return view ('admin.menues.edit' , $data);
    }

    /**
     * Edita el menú con los datos del formulario recibido
     * @param int ID del area
     * @param request Datos
     *
     * @return string
     */
    public function postEdit($id , Request $r){
        $menu = Menu::find($id);
        $menu->descripcion = $r->nombre;
        if ($menu->save()){
            return 'Se ha modificado el area a ' . $menu->descripcion;
        }
    }

    /**
     * Retorna la vista para el alta de una nueva área
     *
     * @return null
     */
    public function getNew(){
    	return view('admin.menues.new');
    }

    /**
     * Dar de alta un menú
     * @param Request r
     *
     * @return string
     */
    public function postNew(Request $r){
    	$menu = new Menu;
    	$menu->descripcion = $r->nombre;
    	if ($menu->save()){
    		return 'Se ha dado de alta el menú ' . $menu->descripcion . ' con el ID : ' . $menu->id_menu;
    	}
    }

    /**
     * Retorna el menu seleccionado con los índices correctos
     * @param int ID del menu a editar
     *
     * @return array
     */
    protected function getMenu ($id){

        $menu_usuario = Menu::where('id_menu' , '=' , $id)->with('relaciones')->get();
        $modulos_activos = [];
        foreach ($menu_usuario as $key => $data) {
            foreach ($data->relaciones as $key => $relacion) {
                $modulos_activos[] = $relacion->id_modulo;
            }
        }    
        

        $modulos = Modulo::orderBy('nivel_1')->orderBy('nivel_2')->get();
        $menu = [];
        foreach ($modulos as $key => $modulo) {
            $menu[$modulo->id_modulo]['href'] = $modulo->id_modulo;
            $menu[$modulo->id_modulo]['text'] = $modulo->descripcion;
            $menu[$modulo->id_modulo]['id_padre'] = $modulo->id_padre;
            if(in_array($modulo->id_modulo , $modulos_activos)) {
                $menu[$modulo->id_modulo]['state'] = [
                    'checked' => 'true'
                ];    
            }
            if ($modulo->arbol == 'S') {
                $menu[$modulo->id_modulo]['nodes'] = [];
            }
        }
        return $menu;
    }

    /**
     * Arma el árbol con todos los módulos disponibles
     *
     * @return json
     */
    public function getTree($id){
        $modulos = $this->getMenu($id);
        foreach ($modulos as $key => $modulo){
            if ($modulo['id_padre']){
                $index = $modulo['id_padre'];
                array_push($modulos[$index]['nodes'] , $modulo);
                unset($modulos[$key]);
            }
        }
        return response()->json(array_values($modulos));
        // echo '<pre>',print_r(json_encode(array_values($modulos),JSON_PRETTY_PRINT)),'</pre>';
    }

    /**
     * Agrega el módulo seleccionado al menu en edición
     * @param int ID del módulo
     * @param int ID del menú
     *
     * @return string
     */
    public function check ($modulo , $menu){
        $mm = new ModuloMenu;
        $mm->id_modulo = $modulo;
        $mm->id_menu = $menu;
        if ($mm->save()){
            return 'Se ha agregado el módulo seleccionado';
        }
    }

    /**
     * Elimina el módulo del menu en edición
     * @param int ID del módulo
     * @param int ID del menú
     *
     * @return string
     */
    public function uncheck ($modulo , $menu){
        $delete = ModuloMenu::where('id_modulo' , '=' , $modulo)->where('id_menu' , '=' , $menu)->delete();
        if ($delete){
            return 'Se ha quitado el módulo seleccionado';
        }
    }
}
