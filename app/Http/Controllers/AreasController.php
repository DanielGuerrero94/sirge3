<?php

namespace App\Http\Controllers;

use Datatables;

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
    	$data = [
    		'page_title' => 'ABM Areas',
    	];
		return view('admin.areas.areas' , $data);
    }

    /**
     * Devuelve el json para la datatable
     * 
     * @return json
     */
    public function tabla(){
        $areas = Area::all();
        return Datatables::of($areas)
            ->addColumn('action' , function($area){
                return '<button id-area="'. $area->id_area .'" class="edit-area btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button>';
            })
            ->make(true);
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
