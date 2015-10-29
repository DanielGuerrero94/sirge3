<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
		$lotes = DDJJSirge::all();
		return Datatables::of($lotes)
			->addColumn('view' , function($lote){
				return '<a href="local" id_impresion="'. $lote->id_impresion .'" class="view-ddjj btn btn-success btn-xs"> Ver DDJJ <i class="fa fa-search"></i></a>';
			})
			->make(true);
	}
}
