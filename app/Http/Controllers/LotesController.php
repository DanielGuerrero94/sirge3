<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;
use App\Models\Lote;

class LotesController extends Controller
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
	 * Devuelve el listado de lotes
	 *
	 * @return null
	 */
	public function listadoLotes($id){
		$data = [
			'page_title' => 'Administración de Lotes',
			'id_padron' => $id
		];
		return view('padrones.admin-lotes' , $data);
	}

	/**
	 * Devuelve el json para armar la datatable
	 *
	 * @return json
	 */
	public function listadoLotesTabla($id){
		$lotes = Lote::with(['estado' , 'archivo' => function($q) use ($id){
			$q->where('id_padron' , $id);
		}]);

		if (Auth::user()->id_entidad == 2) {
			$lotes = $lotes->where('id_provincia' , Auth::user()->id_provincia)->get();
		} else {
			$lotes = $lotes->get();
		}

		return Datatables::of($lotes)
			->addColumn('estado_css' , function($lote){
				return '<span class="label label-' . $lote->estado->css . '">' . $lote->estado->descripcion . '</span>';
			})
			->addColumn('action' , function($lote){
				return '<button lote="'. $lote->lote .'" class="view-lote btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver lote</button>';
			})
			->make(true);
	}
}
