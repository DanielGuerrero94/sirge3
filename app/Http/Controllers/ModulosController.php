<?php

namespace App\Http\Controllers;

use Datatables;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Modulo;

class ModulosController extends Controller
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
     * Devuelve un listado con todos los módulos
     * @param Request
     *
     * @return null
     */
    public function index(Request $r){
    	$data = [
    		'page_title' => 'ABM Modulos'
    	];
   		return view('admin.modulos.modulos' , $data);
    }

    /**
     * Devuelve el json para la datatable
     * 
     * @return json
     */
    public function tabla(){
        $modulos = Modulo::all();
        return Datatables::of($modulos)
            ->addColumn('action' , function($modulo){
                return '<button id-modulo="'. $modulo->id_modulo .'" class="edit-modulo btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button>';
            })
            ->make(true);
    }

    /**
     * Devuelve la vista para el ingreso de un nuevo módulo
     *
     * @return null
     */
    public function getNew(){
        return view('admin.modulos.new');
    }

    /**
     * Da de alta un nuevo módulo
     * @param Request 
     *
     * @return string
     */
    public function postNew(Request $r){
        $m = new Modulo;
        $m->id_padre = $r->id_padre;
        $m->arbol = $r->arbol;
        $m->nivel_1 = $r->nivel_1;
        $m->nivel_2 = $r->nivel_2;
        $m->descripcion = mb_strtoupper($r->nombre);
        $m->modulo = strtolower($r->ruta);
        $m->icono = strtolower($r->icono);

        if ($m->save()){
            return 'Se ha dado de alta el módulo ' . $m->descripcion;
        } else {
            return 'Ha ocurrido un error, por favor revise el formulario';
        }
    }

    /**
     * Devuelve la vista para editar un módulo
     * @param int ID del módulo
     *
     * @return string
     */
    public function getEdit($id){
        $m = Modulo::find($id);
        $data = ['modulo' => $m];
        return view('admin.modulos.edit' , $data);
    }

    /**
     * Actualiza el módulo
     * @param int ID del módulo
     * @param Request
     *
     * @return string
     */
    public function postEdit($id , Request $r){
        $m = Modulo::find($id);
        $m->id_padre = $r->id_padre;
        $m->arbol = $r->arbol;
        $m->nivel_1 = $r->nivel_1;
        $m->nivel_2 = $r->nivel_2;
        $m->descripcion = mb_strtoupper($r->nombre);
        $m->modulo = strtolower($r->ruta);
        $m->icono = strtolower($r->icono);

        if ($m->save()){
            return 'Se ha modificado módulo ' . $m->descripcion;
        } else {
            return 'Ha ocurrido un error, por favor revise el formulario';
        }
    }

}
