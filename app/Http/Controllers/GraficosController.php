<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Grafico;
use App\Models\Geo\Provincia;
use App\Models\Dw\CEB\Ceb001;
use App\Models\Dw\FC\Fc002;

class GraficosController extends Controller
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
     * Retorna la información para armar el gráfico 2
     *
     * @return json
     */
    public function getGafico2($periodo){
        $periodo = str_replace("-", '', $periodo);
        $i = 0;
        $regiones = Ceb001::where('periodo' , $periodo)
                        ->join('geo.provincias as p' , 'c001.id_provincia' , '=' , 'p.id_provincia')
                        ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                        ->select('r.id_region' , 'r.nombre' , DB::raw('sum(cantidad_facturada) as cantidad'))
                        ->groupBy('r.id_region')
                        ->groupBy('r.nombre')
                        ->get();
        foreach ($regiones as $key => $region){
            $data[$i]['color'] = $this->alter_brightness('#0F467F' , $key * 35);
            $data[$i]['id'] = (string)$region->id_region;
            $data[$i]['name'] = $region->nombre;
            $data[$i]['value'] = (int)$region->cantidad;
            $i++;
        }

        for ($j = 0 ; $j <= 5 ; $j ++){
            $provincias = Ceb001::where('periodo' , $periodo)
                            ->where('r.id_region' , $j)
                            ->join('geo.provincias as p' , 'c001.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , DB::raw('sum(cantidad_facturada) as cantidad'))
                            ->groupBy('r.id_region')
                            ->groupBy('p.id_provincia')
                            ->groupBy('p.nombre')
                            ->get();
            foreach ($provincias as $key => $provincia){
                $data[$i]['id'] = $provincia->id_region . "_" . $provincia->id_provincia;
                $data[$i]['name'] = $provincia->nombre;
                $data[$i]['parent'] = (string)$provincia->id_region;
                $data[$i]['value'] = (int)$provincia->cantidad;
                $i++;
            }
        }

        for ($k = 1 ; $k <= 24 ; $k ++){
            $matriz_aux = [];
            $codigos = Ceb001::where('periodo' , $periodo)
                            ->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
                            ->join('geo.provincias as p' , 'c001.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->join('pss.codigos as cg' , 'c001.codigo_prestacion' , '=' , 'cg.codigo_prestacion')
                            ->select('r.id_region' , 'p.id_provincia' , 'c001.codigo_prestacion' , 'cg.descripcion_grupal' , DB::raw('sum(cantidad_facturada) as cantidad'))
                            ->groupBy('r.id_region')
                            ->groupBy('p.id_provincia')
                            ->groupBy('c001.codigo_prestacion')
                            ->groupBy('cg.descripcion_grupal')
                            ->orderBy(DB::raw('sum(cantidad_facturada)') , 'desc')
                            ->take(15)
                            ->get();
            foreach ($codigos as $key => $codigo){
                $matriz_aux[] = $codigo->codigo_prestacion;
                $data[$i]['id'] = $codigo->id_region . "_" . $codigo->id_provincia . "_" . $codigo->codigo_prestacion;
                $data[$i]['name'] = $codigo->codigo_prestacion;
                $data[$i]['parent'] = $codigo->id_region . "_" . $codigo->id_provincia;
                $data[$i]['value'] = (int)$codigo->cantidad;
                $data[$i]['texto_prestacion'] = $codigo->descripcion_grupal;
                $data[$i]['codigo_prestacion'] = true;
                $i++;   
            }

            for ($l = 0 ; $l < count($matriz_aux) ; $l ++){
                $grupos = Ceb001::where('periodo' , $periodo)
                                ->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
                                ->where('codigo_prestacion' , $matriz_aux[$l])
                                ->join('geo.provincias as p' , 'c001.id_provincia' , '=' , 'p.id_provincia')
                                ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                                ->join('pss.grupos_etarios as g' , 'c001.grupo_etario' , '=' , 'g.sigla')
                                ->select('r.id_region' , 'p.id_provincia' , 'c001.codigo_prestacion' , 'g.descripcion' , DB::raw('sum(cantidad_facturada) as cantidad'))
                                ->groupBy('r.id_region')
                                ->groupBy('p.id_provincia')
                                ->groupBy('c001.codigo_prestacion')
                                ->groupBy('g.descripcion')
                                ->get();
                foreach ($grupos as $key => $grupo){
                    $data[$i]['id'] = $grupo->id_region . "_" . $grupo->id_provincia . "_" . $grupo->codigo_prestacion . "_" . $grupo->grupo_etario;
                    $data[$i]['name'] = $grupo->descripcion;
                    $data[$i]['parent'] = $grupo->id_region . "_" . $grupo->id_provincia . "_" . $grupo->codigo_prestacion;
                    $data[$i]['value'] = (int)$grupo->cantidad;
                    $i++;   
                }
            }
        }
        return response()->json($data);
    }

    /**
     * Devuelve la información para armar el gráfico 4
     * @param string $provincia
     * @param int padron
     *
     * @return null
     */
    public function getGafico4($provincia , $padron){
        
    }

    /**
     * Devuelve la información para armar el gráfico 5
     * @param string $periodo
     *
     * @return null
     */
    public function getGrafico5($periodo){
        $periodo = str_replace("-", '', $periodo);
        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');
        
        foreach ($data['categorias'] as $key => $provincia){
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = Fc002::join('pss.codigos_priorizadas as p' , 'estadisticas.fc_002.codigo_prestacion' , '=' , 'p.codigo_prestacion')
                            ->select('id_provincia' , DB::raw('sum(cantidad) as c') , DB::raw('sum(monto) as m'))
                            ->where('periodo' , $periodo)
                            ->groupBy('id_provincia')
                            ->orderBy('id_provincia')
                            ->get();
        foreach ($prestaciones as $key => $prestacion) {
            $data['series'][0]['name'] = 'Prestaciones facturadas';
            $data['series'][0]['data'][] = $prestacion->c;
        }

        return response()->json($data);
    }

    /**
     * Devuelve JSON para la datatable
     *
     *
     */
    public function getGrafico5Tabla($periodo){
        $periodo = str_replace("-", '', $periodo);

        $prestaciones = Fc002::join('pss.codigos_priorizadas as p' , 'estadisticas.fc_002.codigo_prestacion' , '=' , 'p.codigo_prestacion')
                            ->where('periodo' , $periodo);

        if (Auth::user()->id_entidad == 2) {
            $prestaciones->where('id_provincia' , Auth::user()->id_provincia)->get();
        } else {
            $prestaciones->get();
        }

        return Datatables::of($prestaciones)->make(true);
    }
}
