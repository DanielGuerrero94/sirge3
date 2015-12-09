<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Dw\Ca_16_001 as CA;
use App\Models\Geo\Provincia;

class CompromisoController extends Controller
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
	 * Devuelvo la vista para facturación
	 *
	 * @return null
	 */
	public function getDescentralizacion(){

		$dt = new \DateTime();
		$dt->modify('-1 month');

		$categorias = Provincia::orderBy('id_provincia')->lists('descripcion');
		$provincias = CA::join('compromiso_anual.metas_descentralizacion as m' , 'indicadores.ca_16_001.id_provincia' , '=' , 'm.id_provincia')
						->where('periodo' , $dt->format('Ym'))->orderBy('m.id_provincia')->get();

		foreach ($provincias as $key => $provincia){
			$series[0]['type'] = 'column';
			$series[0]['name'] = 'Descentralización';
			$series[0]['color'] = '#b5bbc8';
			$series[0]['data'][] = (int)$provincia->descentralizacion;
			
			$series[1]['type'] = 'scatter';
			$series[1]['name'] = 'Meta 1º semestre';
			$series[1]['data'][] = (int)$provincia->primer_semestre;
			$series[1]['marker']['lineWidth'] = 0;
			$series[1]['marker']['fillColor'] = '#f56954';
			$series[1]['marker']['radius'] = 3;

			$series[2]['type'] = 'scatter';
			$series[2]['name'] = 'Meta 2º semestre';
			$series[2]['data'][] = (int)$provincia->segundo_semestre;
			$series[2]['marker']['lineWidth'] = 0;
			$series[2]['marker']['fillColor'] = '#ff851b';
			$series[2]['marker']['radius'] = 3;
		}


		$data = [
			'page_title' => 'Descentralización',
			'categorias' => json_encode($categorias),
			'series' => json_encode($series),
			'periodo_calculado' => $dt->format('Y-m')
		];

		return view('compromiso-anual.facturacion-uec' , $data);
	}

	/**
	 * Devuelve la vista
	 *
	 * @return null
	 */
	public function getFormPeriodoDescentralizacion(){
		$data = [
			'page_title' => 'Descentralización'
		];
		return view('compromiso-anual.facturacion-periodo' , $data);
	}

	/**
	 * Devuelve la vista
	 *
	 * @return null
	 */
	public function getFormProgresionDescentralizacion(){
		$data = [
			'page_title' => 'Descentralización'
		];
		return view('compromiso-anual.facturacion-provincia' , $data);
	}
}
