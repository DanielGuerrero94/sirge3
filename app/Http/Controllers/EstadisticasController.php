<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Grafico;
use App\Models\Reporte;
use App\Models\Padron;
use App\Models\Geo\Provincia;
use App\Models\Dw\CEB\Ceb001;

class EstadisticasController extends Controller
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
     * Devuelve la vista principal para los graficos
     *
     * @return null
     */
    public function getGraficos(){
    	$data = [
    		'page_title' => 'Gráficos para el análisis de información',
            'graficos' => Grafico::orderBy('id')->get()
    	];
    	return view('estadisticas.graficos.main' , $data);
    }

    /**
     * Devuelve un grafico seleccionado
     * @param int $id
     *
     * @return view
     */
    public function getGrafico($id){
        $g = Grafico::find($id);
    	$data = [
            'provincias' => Provincia::all(),
            'padrones' => Padron::all(),
    		'page_title' => $g->titulo,
            'data' => $g
    	];

        if (is_null($g->form)) {
        	return view('estadisticas.graficos.graficos.' . $id , $data);
        } else {
            return view('estadisticas.graficos.graficos.' . $g->form , $data);
        }
    }

    /**
     * Devuelve la vista del gráfico con los parámetros para realizar las llamadas en Ajax
     * @param int $id
     * @param int $periodo
     *
     * @return null
     */
    public function getGraficoPeriodo($id , $periodo){
        $grafico = Grafico::find($id);
        $data = [
            'page_title' => $grafico->titulo,
            'periodo' => $periodo,
            'grafico' => $grafico
        ];
        return view('estadisticas.graficos.graficos.' . $id , $data);
    }

    /**
     * Devuelve la vista 
     * 
     * @return null
     */
    public function getGraficoProvinciaPadron($id , $provincia , $padron){
        $grafico = Grafico::find($id);
        $data = [
            'page_title' => $grafico->titulo,
            'provincia' => $provincia,
            'padron' => $padron,
            'grafico' => $grafico
        ];
        return view('estadisticas.graficos.graficos.' . $id , $data);
    }

     /**
     * Devuelve la vista principal para los reportes
     *
     * @return null
     */
    public function getReportes(){
        $data = [
            'page_title' => 'Gráficos para el análisis de información',
            'reportes' => Reporte::orderBy('id')->get()
        ];
        return view('estadisticas.reportes.main' , $data);
    }

    /**
     * Devuelve un reporte seleccionado
     * @param int $id
     *
     * @return view
     */
    public function getReporte($id){
        $g = Reporte::find($id);
        $data = [
            'provincias' => Provincia::all(),
            'padrones' => Padron::all(),
            'page_title' => $g->titulo,
            'data' => $g
        ];

        if (is_null($g->form)) {
            return view('estadisticas.graficos.graficos.' . $id , $data);
        } else {
            return view('estadisticas.graficos.graficos.' . $g->form , $data);
        }
    }

    /**
     * Devuelve la vista del reporte con los parámetros para realizar las llamadas en Ajax
     * @param int $id
     * @param int $periodo
     *
     * @return null
     */
    public function getReportePeriodo($id , $periodo){
        $reporte = Grafico::find($id);
        $data = [
            'page_title' => $reporte->titulo,
            'periodo' => $periodo,
            'reporte' => $reporte
        ];
        return view('estadisticas.reportes.reportes.' . $id , $data);
    }


}
