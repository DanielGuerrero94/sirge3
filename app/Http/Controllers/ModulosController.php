<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Classes\Modulo;

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
    	$modulos = Modulo::orderBy('nivel_1')->orderBy('nivel_2')->paginate(15);
    	$modulos->setPath('modulos');
    	$data = [
    		'page_title' => 'ABM Modulos',
    		'modulos' => $modulos
    	];

    	if (sizeof($r->query())){
    		return view('admin.modulos.table' , $data);
    	} else {
    		return view('admin.modulos.modulos' , $data);
    	}
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
        
    }

}
