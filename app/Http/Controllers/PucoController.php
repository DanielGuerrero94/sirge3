<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\PUCO\Puco;
use App\Models\PUCO\ProcesoPuco as Proceso;
use App\Models\PUCO\Provincia;

class PucoController extends Controller
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
	 * Devuelve la vista principal para generar el PUCO
	 *
	 * @return null
	 */
	public function getGenerar(){
		$data = [
			'page_title' => 'Generar PUCO ' . date('M y')
		];
		return view('puco.generar' , $data);
	}

	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function estadisticasTabla(){
		$datos = Puco::all();
		return Datatables::of($datos)->make(true);
	}

	/** 
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function resumenTabla(){
		$datos = Provincia::leftJoin('sistema.subidas_osp' , 'sistema.subidas_osp.codigo_osp' , '=' , 'puco.obras_sociales_provinciales.codigo_osp')
	}
}
