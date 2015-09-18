<?php

namespace App\Http\Controllers;

use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Solicitudes\Operador;
use App\Models\Usuario;

class OperadoresController extends Controller
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
     * Devuelve la vista inicial de operadores
     *
     * @return null
     */
    public function index(){
    	$data = [
    		'page_title' => 'ABM Operadores'
    	];
    	return view('admin.operadores.operadores' , $data);
    }

    public function tabla(){
    	$operators = Operador::with(['usuario','sector'])->get();
    	return Datatables::of($operators)
    		->addColumn('action' , function($operator){
    			if ($operator->habilitado == 'S')
    				return '<button id-operador="'. $operator->id .'" class="disable-operador btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i> Deshabilitar</button>';
    			else 
    				return '<button id-operador="'. $operator->id .'" class="enable-operador btn btn-success btn-xs"><i class="fa fa-pencil-square-o"></i> Habilitar</button>';
    		})
    		->setRowClass(function($operator){
    			return $operator->habilitado == 'N' ? 'danger' : '';
    		})
    		->make(true);
    }

    /**
     * Habilitar un operador
     * @param Request $r
     *
     * @return null
     */
    public function enable(Request $r){
    	$o = Operador::find($r->id_operador);
    	$o->habilitado = 'S';
    	if ($o->save()){
    		return 'Se ha habilitado al operador';
    	}
    }

    /**
     * Deshabilitar un operador
     * @param Request $r
     *
     * @return null
     */
    public function disable(Request $r){
    	$o = Operador::find($r->id_operador);
    	$o->habilitado = 'N';
    	if ($o->save()){
    		return 'Se ha deshabilitado al operador';
    	}
    }

    /**
     * Devuelve la vista para el ingreso de un nuevo operador
     *
     * @return null
     */
    public function getNew(){
    	$u = Usuario::where('id_area' , 1)->where('activo' , 'S')->get();
    	$data = [
    		'usuarios' => $u
    	];
    	return view('admin.operadores.new' , $data);
    }

    /**
     * Ingresa un nuevo operador
     * @param Request $r
     * 
     * @return string
     */
    public function postNew(Request $r){
    	$o = Operador::where('id_usuario' , $r->operador)->where('id_grupo' , $r->grupo)->count();
    	if ($o){
    		return 'El operador ya existe';
    	} else {
	    	$o = new Operador;
	    	$o->id_grupo = $r->grupo;
	    	$o->id_usuario = $r->operador;
	    	$o->habilitado = 'S';
	    	if ($o->save()){
	    		return 'Se ha agregado al operador';
	    	}
    	}
    }
}
