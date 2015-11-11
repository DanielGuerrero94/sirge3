<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Datatables;
use DB;

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
			'page_title' => 'Generar PUCO ' . date('M y'),
			'puco_ready' => $this->checkPuco()
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
						  ->leftJoin('sistema.subidas' , 'sistema.subidas_osp.id_subida' , '=' , 'sistema.subidas.id_subida')
						  ->leftJoin('sistema.lotes' , function ($j) {
					  	  		$j->on('sistema.subidas.id_subida' , '=' , 'sistema.lotes.id_subida')
					  	  		  ->where('sistema.lotes.id_estado' ,'=' , 3);
						  })
						  ->leftJoin('puco.procesos_obras_sociales' , function($j){
						  		$j->on('sistema.lotes.lote' , '=' , 'puco.procesos_obras_sociales.lote')
						  		  ->where('puco.procesos_obras_sociales.periodo' , '=' , date('Ym'));
						  })->leftJoin('puco.obras_sociales' , 'puco.obras_sociales_provinciales.codigo_osp' , '=' , 'puco.obras_sociales.codigo_osp')
						  ->get();
		return Datatables::of($datos)->make(true);
	}

	/**
	 * Devuelve el estado del PUCO
	 *
	 * @return int
	 */
	protected function checkPuco(){
		return Proceso::where('periodo' , date('Ym'))->count();
	}

	/**
	 * Genera el PUCO
	 *
	 * @return string
	 */
	public function generar() {
		DB::statement("
			select rpad (tipo_documento , 3 , ' ')	|| rpad (numero_documento :: text , 12 , ' ') || codigo_os || case when tipo_afiliado = 'T' then 'S' else 'N' end || rpad (nombre_apellido , 30 , ' ')  from puco.beneficiarios_osp union all
			select rpad (tipo_documento , 3 , ' ')	|| rpad (numero_documento :: text , 12 , ' ') || lpad (codigo_os :: text , 6 , '0') || case when codigo_parentesco :: int = 0 then 'S' else 'N' end || rpad (nombre_apellido , 30 , ' ')  from puco.beneficiarios_sss union all
			select rpad (tipo_documento , 3 , ' ')	|| rpad (numero_documento :: text , 12 , ' ') || codigo_os || 'N' || rpad (nombre_apellido , 30 , ' ') from puco.beneficiarios_profe");
	}
}
