<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Dw\Ca_16_001 as CA;
use App\Models\Geo\Provincia;
use App\Models\CA\MetaDescentralizacion as M1;

class CompromisoController extends Controller
{
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
	public function __construct(){
		$this->middleware('auth');
		setlocale(LC_TIME, 'es_ES.UTF-8');
	}

	/**
	 * Devuelvo la vista para facturación
	 *
	 * @return null
	 */
	public function getDescentralizacion($periodo = null){

		if ($periodo) {
			$dt = \DateTime::createFromFormat('Y-m' , $periodo);
			$vista = 'compromiso-anual.facturacion-periodo';
		} else {
			$dt = new \DateTime();
			$dt->modify('-1 month');
			$vista = 'compromiso-anual.facturacion-uec';
		}

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
			'periodo_calculado' => $dt->format('Y-m'),
			'back' => 'compromiso-anual-periodo-form/compromiso-anual-16-descentralizacion'
		];

		return view($vista , $data);
	}

	/**
	 * Devuelve la vista
	 *
	 * @return null
	 */
	public function getFormPeriodo($back){
		$data = [
			'page_title' => 'Descentralización',
			'back' => 'compromiso-anual-16-descentralizacion'
		];
		return view('compromiso-anual.periodo' , $data);
	}

	/**
	 * Devuelve la vista
	 *
	 * @return null
	 */
	public function getFormProvincia($back){

		$provincias = Provincia::orderBy('id_provincia')->get();

		$data = [
			'page_title' => 'Descentralización',
			'provincias' => $provincias,
			'back' => 'compromiso-anual-16-descentralizacion'
		];
		return view('compromiso-anual.provincia' , $data);
	}

	/**
     * Devuelve listado de 12 meses 
     *
     * @return json
     */
    protected function getMesesArray(){

        $dt = new \DateTime();
        $dt->modify('-13 months');
        for ($i = 0 ; $i < 12 ; $i ++){
       		$dt->modify('+1 month');
            $meses[$i] = strftime("%b %Y" , $dt->getTimeStamp());
        }
        return json_encode($meses);
    }

	/**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
    protected function getDateInterval(){

        $dt = new \DateTime();
        $dt->modify('-1 month');
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-11 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

	/**
	 * Devuelve la vista
	 * @param char(2) $id
	 *
	 * @return null
	 */
	public function getDescentralizacionProgresion($id){

		$rango = $this->getDateInterval();
		$metas = M1::where('id_provincia' , $id)->get()[0];

		$periodos = CA::where('id_provincia' , $id)
					->whereBetween('periodo' , [$rango['min'],$rango['max']])
					->get();
		foreach ($periodos as $periodo){
			$chart[0]['name'] = 'Descentralización';
			$chart[0]['data'][] = (real)$periodo->descentralizacion;
		}

		$data = [
			'page_title' => 'Evolución de la descentralización',
			'series' => json_encode($chart),
			'categorias' => $this->getMesesArray(),
			'metas' => $metas,
			'back' => 'compromiso-anual-provincia-form/compromiso-anual-16-descentralizacion'
		];

		return view('compromiso-anual.facturacion-progreso' , $data);

	}
}
