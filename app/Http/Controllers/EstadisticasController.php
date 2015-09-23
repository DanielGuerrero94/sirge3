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
    		'page_title' => 'Gráficos',
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
    		'page_title' => $g->titulo
    	];
    	return view('estadisticas.graficos.graficos.' . $id , $data);
    }

    /**
     * Retorna la información para armar el gráfico 2
     *
     * @return json
     */
    public function getGafico2(){
        $i = 0;
        $regiones = Ceb001::where('periodo' , 201501)
                        ->join('sistema.provincias as p' , 'c001.id_provincia' , '=' , 'p.id_provincia')
                        ->join('sistema.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                        ->select('r.id_region' , 'r.nombre' , DB::raw('sum(cantidad_facturada) as cantidad'))
                        ->groupBy('r.id_region')
                        ->groupBy('r.nombre')
                        ->get();
        foreach ($regiones as $key => $region){
            $data[$i]['color'] = $this->alter_brightness('#0F467F' , $key * 35);
            $data[$i]['id'] = (string)$key;
            $data[$i]['name'] = $region->nombre;
            $data[$i]['value'] = (int)$region->cantidad;
            $i++;
        }

        $provincias = Ceb001::where('periodo' , 201501)
                        ->where('r.id_region' , 1)
                        ->join('sistema.provincias as p' , 'c001.id_provincia' , '=' , 'p.id_provincia')
                        ->join('sistema.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                        ->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , DB::raw('sum(cantidad_facturada) as cantidad'))
                        ->groupBy('r.id_region')
                        ->groupBy('p.id_provincia')
                        ->groupBy('p.nombre')
                        ->get();
        foreach ($provincias as $key => $provincia){
            $data[$i]['id'] = "1_" . (string)$key;
            $data[$i]['name'] = $provincia->nombre;
            $data[$i]['parent'] = 1;
            $data[$i]['value'] = (int)$provincia->cantidad;
            $i++;
        }


        return response()->json($data);
    }

}
