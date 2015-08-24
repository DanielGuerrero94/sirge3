<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Area;

class AreasController extends Controller
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
     * Devuelve el listado de areas
     * @param Request
     * 
     * @return void
     */
    public function index(Request $r){
    	$areas = Area::orderBy('id_area')->paginate(15);
    	$areas->setPath('areas');
    	$data = [
    		'page_title' => 'ABM Areas',
    		'areas' => $areas
    	];

    	if (sizeof($r->query())){
    		return view('admin.areas.table' , $data);
    	} else {
    		return view('admin.areas.areas' , $data);
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
        return view ('admin.areas.edit' , $data);
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
    	return view('admin.areas.new');
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
