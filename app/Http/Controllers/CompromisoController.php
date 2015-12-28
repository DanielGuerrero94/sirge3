<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Dw\CA\CA16001 as CA;
use App\Models\Geo\Provincia;
use App\Models\CA\MetaDescentralizacion as M1;
use App\Models\CA\MetaFacturacion as M2;
use App\Models\CA\MetaDatoReportable as M3;
use App\Models\CA\MetaDependenciaSanitaria as M4;

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
	 *
	 * @return null
	 */
	public function getFormPeriodo($back , $modulo){
		$data = [
			'page_title' => 'Filtros',
			'back' => $back,
			'modulo' => $modulo
		];
		return view('compromiso-anual.periodo' , $data);
	}

	/**
	 * Devuelve la vista
	 *
	 * @return null
	 */
	public function getFormProvincia($back , $modulo){

		$provincias = Provincia::orderBy('id_provincia')->get();

		$data = [
			'page_title' => 'Filtros',
			'provincias' => $provincias,
			'back' => $back,
			'modulo' => $modulo
		];
		return view('compromiso-anual.provincia' , $data);
	}

	/**
	 * Devuelvo la vista para facturación
	 *
	 * @return null
	 */
	public function getDescentralizacion($periodo = null){

		if ($periodo) {
			$dt = \DateTime::createFromFormat('Y-m' , $periodo);
			$vista = 'compromiso-anual.descentralizacion-periodo';
		} else {
			$dt = new \DateTime();
			$dt->modify('-1 month');
			$vista = 'compromiso-anual.descentralizacion-uec';
		}

		$categorias = Provincia::orderBy('id_provincia')->lists('descripcion');
		$provincias = CA::join('compromiso_anual.metas_descentralizacion as m' , 'indicadores.ca_16_001.id_provincia' , '=' , 'm.id_provincia')
						->where('periodo' , $dt->format('Ym'))->orderBy('m.id_provincia')->get();

		foreach ($provincias as $key => $provincia){
			$series[0]['type'] = 'column';
			$series[0]['name'] = 'Descentralización';
			$series[0]['color'] = '#b5bbc8';
			$series[0]['data'][] = (float)$provincia->descentralizacion;
			
			$series[1]['type'] = 'scatter';
			$series[1]['name'] = 'Meta 1º cuatrimestre';
			$series[1]['data'][] = (float)$provincia->primer_cuatrimestre;
			$series[1]['marker']['lineWidth'] = 0;
			$series[1]['marker']['fillColor'] = '#00a65a';
			$series[1]['marker']['radius'] = 3;
			$series[1]['marker']['symbol'] = 'circle';

			$series[2]['type'] = 'scatter';
			$series[2]['name'] = 'Meta 2º cuatrimestre';
			$series[2]['data'][] = (float)$provincia->segundo_cuatrimestre;
			$series[2]['marker']['lineWidth'] = 0;
			$series[2]['marker']['fillColor'] = '#ff851b';
			$series[2]['marker']['radius'] = 3;
			$series[2]['marker']['symbol'] = 'circle';

			$series[3]['type'] = 'scatter';
			$series[3]['name'] = 'Meta 3º cuatrimestre';
			$series[3]['data'][] = (float)$provincia->tercer_cuatrimestre;
			$series[3]['marker']['lineWidth'] = 0;
			$series[3]['marker']['fillColor'] = '#d33724';
			$series[3]['marker']['radius'] = 3;
			$series[3]['marker']['symbol'] = 'circle';
		}


		$data = [
			'page_title' => 'Descentralización',
			'categorias' => json_encode($categorias),
			'series' => json_encode($series),
			'periodo_calculado' => $dt->format('Y-m'),
			'back' => 'ca-periodo-form/ca-16-descentralizacion/ca-16-descentralizacion'
		];

		return view($vista , $data);
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
			'back' => 'ca-provincia-form/ca-16-descentralizacion/ca-16-descentralizacion-progresion'
		];

		return view('compromiso-anual.descentralizacion-progreso' , $data);
	}

	/**
	 * Devuelve vista
	 *
	 * @return null
	 */
	public function getFacturacion($periodo = null){
		if ($periodo) {
			$dt = \DateTime::createFromFormat('Y-m' , $periodo);
			$vista = 'compromiso-anual.facturacion-periodo';
		} else {
			$dt = new \DateTime();
			$dt->modify('-1 month');
			$vista = 'compromiso-anual.facturacion-uec';
		}

		$categorias = Provincia::orderBy('id_provincia')->lists('descripcion');
		$provincias = CA::join('compromiso_anual.metas_facturacion as m' , 'indicadores.ca_16_001.id_provincia' , '=' , 'm.id_provincia')
						->where('periodo' , $dt->format('Ym'))->orderBy('m.id_provincia')->get();

		foreach ($provincias as $key => $provincia){
			$series[0]['type'] = 'column';
			$series[0]['name'] = 'Facturación';
			$series[0]['color'] = '#b5bbc8';
			$series[0]['data'][] = (float)$provincia->volumen;
			
			$series[1]['type'] = 'scatter';
			$series[1]['name'] = 'Meta 1º cuatrimestre';
			$series[1]['data'][] = (float)$provincia->primer_cuatrimestre;
			$series[1]['marker']['lineWidth'] = 0;
			$series[1]['marker']['fillColor'] = '#00a65a';
			$series[1]['marker']['radius'] = 3;
			$series[1]['marker']['symbol'] = 'circle';

			$series[2]['type'] = 'scatter';
			$series[2]['name'] = 'Meta 2º cuatrimestre';
			$series[2]['data'][] = (float)$provincia->segundo_cuatrimestre;
			$series[2]['marker']['lineWidth'] = 0;
			$series[2]['marker']['fillColor'] = '#ff851b';
			$series[2]['marker']['radius'] = 3;
			$series[2]['marker']['symbol'] = 'circle';

			$series[3]['type'] = 'scatter';
			$series[3]['name'] = 'Meta 2º cuatrimestre';
			$series[3]['data'][] = (float)$provincia->tercer_cuatrimestre;
			$series[3]['marker']['lineWidth'] = 0;
			$series[3]['marker']['fillColor'] = '#d33724';
			$series[3]['marker']['radius'] = 3;
			$series[3]['marker']['symbol'] = 'circle';
		}


		$data = [
			'page_title' => 'Facturación descentralizada',
			'categorias' => json_encode($categorias),
			'series' => json_encode($series),
			'periodo_calculado' => $dt->format('Y-m'),
			'back' => 'ca-periodo-form/ca-16-facturacion/ca-16-facturacion'
		];

		return view($vista , $data);
	}

	/**
	 * Devuelve la vista para una provincia
	 * @param string $id
	 *
	 * @return null
	 */
	public function getFacturacionProgresion($id){

		$rango = $this->getDateInterval();
		$metas = M2::where('id_provincia' , $id)->get()[0];

		$periodos = CA::where('id_provincia' , $id)
					->whereBetween('periodo' , [$rango['min'],$rango['max']])
					->get();
		foreach ($periodos as $periodo){
			$chart[0]['name'] = 'Facturación';
			$chart[0]['data'][] = (real)$periodo->volumen;
		}

		$data = [
			'page_title' => 'Evolución de la facturacion descentralizada',
			'series' => json_encode($chart),
			'categorias' => $this->getMesesArray(),
			'metas' => $metas,
			'back' => 'ca-provincia-form/ca-16-facturacion/ca-16-facturacion-progresion'
		];

		return view('compromiso-anual.facturacion-progreso' , $data);
	}

	/**
	 * Devuelve vista
	 *
	 * @return null
	 */
	public function getDatos($periodo = null){
		if ($periodo) {
			$dt = \DateTime::createFromFormat('Y-m' , $periodo);
			$vista = 'compromiso-anual.datos-periodo';
		} else {
			$dt = new \DateTime();
			$dt->modify('-1 month');
			$vista = 'compromiso-anual.datos-uec';
		}

		$categorias = Provincia::orderBy('id_provincia')->lists('descripcion');
		$provincias = CA::join('compromiso_anual.metas_datos_reportables as m' , 'indicadores.ca_16_001.id_provincia' , '=' , 'm.id_provincia')
						->where('periodo' , $dt->format('Ym'))->orderBy('m.id_provincia')->get();

		foreach ($provincias as $key => $provincia){
			$series[0]['type'] = 'column';
			$series[0]['name'] = 'Datos reportables';
			$series[0]['color'] = '#b5bbc8';
			$series[0]['data'][] = (float)$provincia->datos_reportables;
			
			$series[1]['type'] = 'scatter';
			$series[1]['name'] = 'Meta 1º cuatrimestre';
			$series[1]['data'][] = (float)$provincia->primer_cuatrimestre;
			$series[1]['marker']['lineWidth'] = 0;
			$series[1]['marker']['fillColor'] = '#00a65a';
			$series[1]['marker']['radius'] = 3;
			$series[1]['marker']['symbol'] = 'circle';

			$series[2]['type'] = 'scatter';
			$series[2]['name'] = 'Meta 2º cuatrimestre';
			$series[2]['data'][] = (float)$provincia->segundo_cuatrimestre;
			$series[2]['marker']['lineWidth'] = 0;
			$series[2]['marker']['fillColor'] = '#ff851b';
			$series[2]['marker']['radius'] = 3;
			$series[2]['marker']['symbol'] = 'circle';

			$series[3]['type'] = 'scatter';
			$series[3]['name'] = 'Meta 3º cuatrimestre';
			$series[3]['data'][] = (float)$provincia->tercer_cuatrimestre;
			$series[3]['marker']['lineWidth'] = 0;
			$series[3]['marker']['fillColor'] = '#d33724';
			$series[3]['marker']['radius'] = 3;
			$series[3]['marker']['symbol'] = 'circle';
		}


		$data = [
			'page_title' => 'Datos reportables',
			'categorias' => json_encode($categorias),
			'series' => json_encode($series),
			'periodo_calculado' => $dt->format('Y-m'),
			'back' => 'ca-periodo-form/ca-16-datos-reportables/ca-16-datos-reportables'
		];

		return view($vista , $data);
	}

	/**
	 * Devuelve la vista para una provincia
	 * @param string $id
	 *
	 * @return null
	 */
	public function getDatosProgresion($id){

		$rango = $this->getDateInterval();
		$metas = M3::where('id_provincia' , $id)->get()[0];

		$periodos = CA::where('id_provincia' , $id)
					->whereBetween('periodo' , [$rango['min'],$rango['max']])
					->get();
		foreach ($periodos as $periodo){
			$chart[0]['name'] = 'Datos reportables';
			$chart[0]['data'][] = (real)$periodo->datos_reportables;
		}

		$data = [
			'page_title' => 'Evolución del reporte de datos reportables',
			'series' => json_encode($chart),
			'categorias' => $this->getMesesArray(),
			'metas' => $metas,
			'back' => 'ca-provincia-form/ca-16-datos-reportables/ca-16-datos-reportables-progresion'
		];

		return view('compromiso-anual.datos-progreso' , $data);
	}

	/**
	 * Devuelve vista
	 *
	 * @return null
	 */
	public function getDependencia($periodo = null){
		if ($periodo) {
			$dt = \DateTime::createFromFormat('Y-m' , $periodo);
			$vista = 'compromiso-anual.dependencia-periodo';
		} else {
			$dt = new \DateTime();
			$dt->modify('-1 month');
			$vista = 'compromiso-anual.dependencia-uec';
		}

		$categorias = Provincia::orderBy('id_provincia')->lists('descripcion');
		$provincias = CA::join('compromiso_anual.metas_dependencias_sanitarias as m' , 'indicadores.ca_16_001.id_provincia' , '=' , 'm.id_provincia')
						->where('periodo' , $dt->format('Ym'))->orderBy('m.id_provincia')->get();

		foreach ($provincias as $key => $provincia){
			$series[0]['type'] = 'column';
			$series[0]['name'] = 'Dependencias Sanitarias';
			$series[0]['color'] = '#b5bbc8';
			$series[0]['data'][] = (float)$provincia->dependencia_sanitaria;
			
			$series[1]['type'] = 'scatter';
			$series[1]['name'] = 'Meta 1º cuatrimestre';
			$series[1]['data'][] = (float)$provincia->primer_cuatrimestre;
			$series[1]['marker']['lineWidth'] = 0;
			$series[1]['marker']['fillColor'] = '#00a65a';
			$series[1]['marker']['radius'] = 3;
			$series[1]['marker']['symbol'] = 'circle';

			$series[2]['type'] = 'scatter';
			$series[2]['name'] = 'Meta 2º cuatrimestre';
			$series[2]['data'][] = (float)$provincia->segundo_cuatrimestre;
			$series[2]['marker']['lineWidth'] = 0;
			$series[2]['marker']['fillColor'] = '#ff851b';
			$series[2]['marker']['radius'] = 3;
			$series[2]['marker']['symbol'] = 'circle';

			$series[3]['type'] = 'scatter';
			$series[3]['name'] = 'Meta 3º cuatrimestre';
			$series[3]['data'][] = (float)$provincia->tercer_cuatrimestre;
			$series[3]['marker']['lineWidth'] = 0;
			$series[3]['marker']['fillColor'] = '#d33724';
			$series[3]['marker']['radius'] = 3;
			$series[3]['marker']['symbol'] = 'circle';
		}


		$data = [
			'page_title' => 'Dependencias Sanitarias',
			'categorias' => json_encode($categorias),
			'series' => json_encode($series),
			'periodo_calculado' => $dt->format('Y-m'),
			'back' => 'ca-periodo-form/ca-16-dependencia/ca-16-dependencia'
		];

		return view($vista , $data);
	}

	/**
	 * Devuelve la vista para una provincia
	 * @param string $id
	 *
	 * @return null
	 */
	public function getDependenciaProgresion($id){

		$rango = $this->getDateInterval();
		$metas = M4::where('id_provincia' , $id)->get()[0];

		$periodos = CA::where('id_provincia' , $id)
					->whereBetween('periodo' , [$rango['min'],$rango['max']])
					->get();
		foreach ($periodos as $periodo){
			$chart[0]['name'] = 'Dependencias Sanitarias';
			$chart[0]['data'][] = (real)$periodo->dependencia_sanitaria;
		}

		$data = [
			'page_title' => 'Evolución de dependencias sanitarias',
			'series' => json_encode($chart),
			'categorias' => $this->getMesesArray(),
			'metas' => $metas,
			'back' => 'ca-provincia-form/ca-16-dependencia/ca-16-dependencia-progresion'
		];

		return view('compromiso-anual.dependencia-progreso' , $data);
	}
}
