<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Grafico;
use App\Models\Dw\Ceb001;

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
     * Aclara el color base
     * @param int
     *
     * @return string
     */
    protected function alter_brightness($colourstr, $steps) {
        $colourstr = str_replace('#','',$colourstr);
        $rhex = substr($colourstr,0,2);
        $ghex = substr($colourstr,2,2);
        $bhex = substr($colourstr,4,2);

        $r = hexdec($rhex);
        $g = hexdec($ghex);
        $b = hexdec($bhex);

        $r = max(0,min(255,$r + $steps));
        $g = max(0,min(255,$g + $steps));  
        $b = max(0,min(255,$b + $steps));

        return '#'.str_pad(dechex($r) , 2 , '0' , STR_PAD_LEFT).str_pad(dechex($g) , 2 , '0' , STR_PAD_LEFT).str_pad(dechex($b) , 2 , '0' , STR_PAD_LEFT);
    }

    /**
     * Devuelve la vista principal para los graficos
     *
     * @return null
     */
    public function getGraficos(){
    	$data = [
    		'page_title' => 'Gráficos para el análisis de información',
            'graficos' => Grafico::all()
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
            'periodo' => $periodo
        ];
        return view('estadisticas.graficos.graficos.' . $id , $data);
    }

   

}
