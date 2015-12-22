<?php

namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;
use App\Models\Dw\CEB\Ceb001;
use App\Models\Dw\CEB\Ceb002;

class CebController extends Controller
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
	 * Devuelve la vista para ingresar el periodo
	 *
	 * @return null
	 */
	public function getPeriodo(){
		$data = [
			'page_title' => 'Filtros'
		];
		return view('ceb.periodo' , $data);
	}

	/**
     * Devuelve listado de 6 meses 
     *
     * @return json
     */
    protected function getMesesArray($periodo){

        $dt = \DateTime::createFromFormat('Y-m' , $periodo);
        $dt->modify('-6 month');
        for ($i = 0 ; $i < 6 ; $i ++){
        $dt->modify('+1 month');

            $meses[$i] = strftime("%b" , $dt->getTimeStamp());
        }
        return json_encode($meses);
    }

	/**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
    protected function getDateInterval($periodo){

        $dt = \DateTime::createFromFormat('Y-m' , $periodo);
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-5 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

	/**
     * Devuelve la info para generar un gráfico
     * 
     * @return json
     */
    protected function getProgresoCeb($periodo){

        $interval = $this->getDateInterval($periodo);

        $periodos = Ceb002::select('periodo' , DB::raw('sum(beneficiarios_activos) as b') , DB::raw('sum(beneficiarios_ceb) as c') , DB::raw('sum(beneficiarios_registrados) as i'))
                    ->whereBetween('periodo',[$interval['min'],$interval['max']])
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();

        foreach($periodos as $key => $periodo){
            $chart[0]['name'] = 'Benef. CEB';
            $chart[0]['data'][$key] = $periodo->c;

            $chart[1]['name'] = 'Benef. ACT';
            $chart[1]['data'][$key] = $periodo->b;
            
        }
        return json_encode($chart);
    }

    /**
     * Devuelve las provincias en un array
     *
     * @return null
     */
    protected function getProvinciasArray(){
    	$data = Provincia::orderBy('id_provincia')->lists('descripcion');
    	foreach ($data as $key => $provincia){
            $data[$key] = ucwords(mb_strtolower($provincia));
        }
        return $data;
    }

    /** 
     * Devuelve la info para armar un gráfico
	 * @param string $periodo
     *
	 * @return json
	 */
    protected function getDistribucionProvincial($periodo){
    	$periodo = str_replace('-', '', $periodo);
    	$provincias_ceb = Ceb002::where('periodo' , $periodo)->get();

    	foreach ($provincias_ceb as $key => $provincia){
    		$chart[0]['name'] = 'Benef. CEB';
            $chart[0]['data'][$key] = $provincia->beneficiarios_ceb;

            $chart[1]['name'] = 'Benef. ACT';
            $chart[1]['data'][$key] = $provincia->beneficiarios_activos;
    	}

    	return json_encode($chart);
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
     * Retorna la información para armar el gráfico complicado
     *
     * @return json
     */
    public function getDistribucionCodigos($periodo){
        $periodo = str_replace("-", '', $periodo);
        $i = 0;
        $regiones = Ceb001::where('periodo' , $periodo)
                        ->join('geo.provincias as p' , 'c001.id_provincia' , '=' , 'p.id_provincia')
                        ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                        ->select('r.id_region' , 'r.nombre' , DB::raw('sum(cantidad) as cantidad'))
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
                            ->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , DB::raw('sum(cantidad) as cantidad'))
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
                            ->select('r.id_region' , 'p.id_provincia' , 'c001.codigo_prestacion' , 'cg.descripcion_grupal' , DB::raw('sum(cantidad) as cantidad'))
                            ->groupBy('r.id_region')
                            ->groupBy('p.id_provincia')
                            ->groupBy('c001.codigo_prestacion')
                            ->groupBy('cg.descripcion_grupal')
                            ->orderBy(DB::raw('sum(cantidad)') , 'desc')
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
                                ->select('r.id_region' , 'p.id_provincia' , 'c001.codigo_prestacion' , 'g.descripcion' , DB::raw('sum(cantidad) as cantidad'))
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
        return json_encode($data);
    }
    
	/** 
	 * Devuelve la vista del resumen
	 * @param string $periodo
	 *
	 * @return null
	 */
	public function getResumen($periodo){
		$data = [
			'page_title' => 'Resumen mensual C.E.B., período ' . $periodo,
			'progreso_ceb_series' => $this->getProgresoCeb($periodo),
			'progreso_ceb_categorias' => $this->getMesesArray($periodo),
			'distribucion_provincial_categorias' => $this->getProvinciasArray(),
			'distribucion_provincial_series' => $this->getDistribucionProvincial($periodo),
			'treemap_data' => $this->getDistribucionCodigos($periodo)

		];
		return view('ceb.resumen' , $data);
	}
}
