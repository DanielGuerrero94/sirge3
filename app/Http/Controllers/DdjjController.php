<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Datatables;
use PDF;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;
use App\Models\DDJJ\Sirge as DDJJSirge;

class DdjjController extends Controller
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
	 * Devuelve la vista con los lotes a declarar
	 * @param int $padron
	 *
	 * @return null
	 */
	public function getListadoPendientes($padron){
		$pendientes = DB::table('sistema.lotes as l')
				->join('sistema.lotes_aceptados as a' , 'l.lote' , '=' , 'a.lote')
				->join('sistema.subidas as s' , 'l.id_subida' , '=' , 's.id_subida')
				->where('s.id_padron' , $padron)
				->whereNotIn('l.lote' , function($q){
					$q->select(DB::raw('unnest(lote)'))
					->from('ddjj.sirge');
				})
				->count();

		$data = [
			'page_title' => 'Declaración de lotes para DDJJ',
			'padron' => $padron,
			'pendientes' => $pendientes
		];
		return view('padrones.ddjj' , $data);
	}

	/**
	 * Devuelve el json para la datatable
	 * @param int $padron
	 *
	 * @return json
	 */
	public function getListadoPendientesTabla($padron){
		$lotes = DB::table('sistema.lotes as l')
				->join('sistema.lotes_aceptados as a' , 'l.lote' , '=' , 'a.lote')
				->join('sistema.subidas as s' , 'l.id_subida' , '=' , 's.id_subida')
				->where('s.id_padron' , $padron)
				->whereNotIn('l.lote' , function($q){
					$q->select(DB::raw('unnest(lote)'))
					->from('ddjj.sirge');
				})
				->select('l.*' , 'a.fecha_aceptado');

		return Datatables::of($lotes)
			->addColumn('fecha_format' , function($lote){
				return date_format(date_create($lote->fecha_aceptado) , 'd/m/Y');
			})->make(true);
	}

	/**
	 * Retorna la vista de las DDJJ por padrón
	 * @param int $id
	 *
	 * @return null
	 */
	public function getListado($id){
		$data = [
			'page_title' => 'Histórico de declaraciones juradas',
			'padron' => $id
		];
		return view('padrones.ddjj-historico' , $data);
	}

	/**
	 * Retorna un JSON para la datatable
	 * @param int $id
	 *
	 * @return json
	 */
	public function getListadoTabla($id){
		$lotes = DDJJSirge::join('sistema.lotes' , 'sistema.lotes.lote' , '=' , DB::raw('any(ddjj.sirge.lote)'))
			->join('sistema.subidas' , 'sistema.lotes.id_subida' , '=' , 'sistema.subidas.id_subida')
			->where('id_padron' , $id)
			->groupBy('ddjj.sirge.id_impresion')
			->groupBy('ddjj.sirge.lote')
			->groupBy('sistema.subidas.id_padron')
			->select('ddjj.sirge.*' , 'sistema.subidas.id_padron');
		if (Auth::user()->id_entidad == 2) {
			$lotes->where('id_provincia' , Auth::user()->id_provincia);
		}

		$lotes = $lotes->get();
		
		return Datatables::of($lotes)
			->addColumn('view' , function($lote){
				return '<a href="ddjj-sirge/' . $lote->id_padron . '/' . $lote->id_impresion . '" id_impresion="'. $lote->id_impresion .'" class="view-ddjj btn btn-success btn-xs"> Ver DDJJ <i class="fa fa-search"></i></a>';
			})
			->make(true);
	}

	/**
	 * Devuelve el nombre del padron correspondiente
	 * @param int $id
	 *
	 * @return string
	 */
	protected function getNombrePadron($id){
		switch ($id) {
			case '1':	return 'PRESTACIONES';
			case 2: return 'APLICACIÓN DE FONDOS';
			case 3: return 'COMPROBANTES';
			case 4: return 'OBRA SOCIAL PROVINCIAL';
			case 5: return 'PROGRAMA FEDERAL DE SALUD';
			case 6: return 'SUPERINTENDENCIA DE SERVICIOS DE SALUD';
			default: break;
		}
	}

	/**
	 * Devuelve la DDJJ Sirge elegida
	 * @param int $id
	 *
	 * @return resource
	 */
	public function getDDJJSirge($padron , $id){
		$resumen = [
			'in' => 0,
			'out' => 0,
			'mod' => 0
		];

		$lotes = DDJJSirge::join('sistema.lotes' , 'sistema.lotes.lote' , '=' , DB::raw('any(ddjj.sirge.lote)'))
			->where('id_impresion' , $id)
			->get();
		
		foreach ($lotes as $key => $lote){
			$resumen['in'] += $lote->registros_in;
			$resumen['out'] += $lote->registros_out;
			$resumen['mod'] += $lote->registros_mod;
		}

		$data = [
			'lotes' => $lotes,
			'nombre_padron' => $this->getNombrePadron($padron),
			'resumen' => $resumen,
			'jurisdiccion' => Provincia::where('id_provincia' , Auth::user()->id_provincia)->firstOrFail(),
			'ddjj' => DDJJSirge::findOrFail($id)
		];

		$pdf = PDF::loadView('pdf.ddjj.sirge' , $data);
    	return $pdf->download("ddjj-sirge-$id.pdf");
	}

}
