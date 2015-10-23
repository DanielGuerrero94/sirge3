<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;
use App\Models\Lote;
use App\Models\LoteAceptado;
use App\Models\LoteRechazado;
use App\Models\Rechazo;

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
		$lotes = Lote::with('estado')
			->join('sistema.subidas' , 'sistema.lotes.id_subida' , '=' , 'sistema.subidas.id_subida')
			->where('id_padron' , $id)
			->where('id_provincia' , Auth::user()->id_provincia)
			->select('sistema.lotes.*');

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

	/**
	 * Devuelve el detalle del lote seleccionado
	 * @param int $lote
	 *
	 * @return null
	 */
	public function detalleLote($lote){
		$lote = Lote::with(['estado' , 'archivo' , 'usuario' , 'provincia'])->findOrFail($lote);
		
		$data = [
			'page_title' => 'Detalle lote ' . $lote->lote,
			'lote' => $lote
		];

		return view ('padrones.detail-lote' , $data);
	}

	/**
	 * Marco el lote como aceptado
	 * @param Request $r
	 *
	 * @return string
	 */
	public function aceptarLote(Request $r){
		$l = Lote::findOrFail($r->lote);
		$l->id_estado = 3;
		if ($l->save()){
			$la = new LoteAceptado;
			$la->lote = $l->lote;
			$la->id_usuario = Auth::user()->id_usuario;
			$la->fecha_aceptado = 'now';
			if ($la->save()){
				return 'Se ha aceptado el lote. Recuerde declararlo para imprimir la DDJJ.';
			}
		}
	}

	/**
	 * Marco el lote como rechazado
	 * @param Request $r
	 *
	 * @return string
	 */
	public function eliminarLote(Request $r){
		$l = Lote::findOrFail($r->lote);
		$l->id_estado = 4;
		if ($l->save()){
			$lr = new LoteRechazado;
			$lr->lote = $l->lote;
			$lr->id_usuario = Auth::user()->id_usuario;
			$lr->fecha_rechazado = 'now';
			if ($lr->save()){
				return 'Se ha rechazado el lote.';
			}
		}
	}

	/**
	 * Devuelve la vista de rechazos
	 * @param int $lote
	 *
	 * @return null
	 */
	public function getRechazos($lote){
		$data = [
			'page_title' => 'Listado de rechazos lote : ' . $lote,
			'lote' => $lote
		];
		return view('padrones.rechazos' , $data);
	}

	/**
	 * Devuelve el json para armar la datatable
	 * @param int $lote
	 *
	 * @return json
	 */
	public function getRechazosTabla($lote){
		$rechazos = Rechazo::where('lote' , $lote)->get();
		return Datatables::of($rechazos)
			->make(true);
	}
}
