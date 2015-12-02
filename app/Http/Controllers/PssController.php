<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Salud;

class PssController extends Controller
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
	 * Devuelve la vista principal del listado PSS
	 *
	 * @return null
	 */
	public function getListado(){
		$data = [
			'page_title' => 'Plan de Servicios de Salud'
		];
		return view('pss.index' , $data);
	}

	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function getListadoTabla(){
		$pss = Salud::all();
		return Datatables::of($pss)
			->editColumn('descripcion_grupal' , '{!! str_limit($descripcion_grupal, 60) !!}')
			->addColumn('action' , function($ps){
				return '<button codigo="'. $ps->codigo_prestacion .'" class="ver btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
			})
			->make(true);
	}
}
