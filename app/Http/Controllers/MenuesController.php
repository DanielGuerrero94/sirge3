<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Menu;

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
     * @return void
     */
    public function index(Request $r){
    	$menues = Menu::orderBy('id_menu')->paginate(15);
    	$menues->setPath('menues');
    	$data = [
    		'page_title' => 'ABM Menues',
    		'menues' => $menues
    	];

    	if (sizeof($r->query())){
    		return view('admin.menues-table' , $data);
    	} else {
    		return view('admin.menues' , $data);
    	}
    }

    /**
     * Devuelve la vista para editar un area
     * @param int ID del area
     *
     * @return void
     */
    public function getEdit($id){
        $area = Area::find($id);
        $data = [
            'area' => $area,
        ];
        return view ('admin.areas-edit' , $data);
    }

    /**
     * Edita el area con los datos del formulario recibido
     * @param int ID del area
     * @param request Datos
     *
     * @return string
     */
    public function postEdit($id , Request $r){
        $area = Area::find($id);
        $area->nombre = $r->nombre;
        if ($area->save()){
            return 'Se ha modificado el area a ' . $area->nombre;
        }
    }

    /**
     * Retorna la vista para el alta de una nueva área
     *
     * @return null
     */
    public function getNew(){
    	return view('admin.menues-new');
    }

    /**
     * Dar de alta un área
     * @param Request r
     *
     * @return string
     */
    public function postNew(Request $r){
    	$area = new Area;
    	$area->nombre = $r->nombre;
    	if ($area->save()){
    		return 'Se ha dado de alta el área ' . $area->nombre . ' con el ID : ' . $area->id_area;
    	}
    }
}
