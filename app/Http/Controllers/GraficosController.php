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
use App\Models\Dw\FC\Fc001;
use App\Models\Dw\FC\Fc002;
use App\Models\Dw\FC\Fc004;
use App\Models\Dw\FC\Fc005;
use App\Models\Dw\FC\Fc006;
use App\Models\Dw\FC\Fc007;
use App\Models\Dw\FC\Fc008;
use App\Models\Dw\FC\Fc009;
use App\Models\PSS\DatoReportable;

class GraficosController extends Controller
{

     /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
     public function __construct()
     {
        $this->middleware('auth');
        setlocale(LC_TIME, 'es_ES.UTF-8');
    }

    /**
     * Aclara el color base
     * @param int
     *
     * @return string
     */
    protected function alter_brightness($colourstr, $steps)
    {
        $colourstr = str_replace('#', '', $colourstr);
        $rhex = substr($colourstr, 0, 2);
        $ghex = substr($colourstr, 2, 2);
        $bhex = substr($colourstr, 4, 2);

        $r = hexdec($rhex);
        $g = hexdec($ghex);
        $b = hexdec($bhex);

        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));

        return '#'.str_pad(dechex($r), 2, '0', STR_PAD_LEFT).str_pad(dechex($g), 2, '0', STR_PAD_LEFT).str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }


    /**
     * Retorna la información para armar el gráfico 2
     *
     * @return json
     */
    public function getGrafico2($periodo)
    {
        $periodo = str_replace("-", '', $periodo);
        $i = 0;
        $regiones = Ceb001::where('periodo', $periodo)
        ->join('geo.provincias as p', 'c001.id_provincia', '=', 'p.id_provincia')
        ->join('geo.regiones as r', 'p.id_region', '=', 'r.id_region')
        ->select('r.id_region', 'r.nombre', DB::raw('sum(cantidad) as cantidad'))
        ->groupBy('r.id_region')
        ->groupBy('r.nombre')
        ->get();
        foreach ($regiones as $key => $region) {
            $data[$i]['color'] = $this->alter_brightness('#0F467F', $key * 35);
            $data[$i]['id'] = (string)$region->id_region;
            $data[$i]['name'] = $region->nombre;
            $data[$i]['value'] = (int)$region->cantidad;
            $i++;
        }

        for ($j = 0; $j <= 5; $j ++) {
            $provincias = Ceb001::where('periodo', $periodo)
            ->where('r.id_region', $j)
            ->join('geo.provincias as p', 'c001.id_provincia', '=', 'p.id_provincia')
            ->join('geo.regiones as r', 'p.id_region', '=', 'r.id_region')
            ->select('r.id_region', 'p.id_provincia', 'p.nombre', DB::raw('sum(cantidad) as cantidad'))
            ->groupBy('r.id_region')
            ->groupBy('p.id_provincia')
            ->groupBy('p.nombre')
            ->get();
            foreach ($provincias as $key => $provincia) {
                $data[$i]['id'] = $provincia->id_region . "_" . $provincia->id_provincia;
                $data[$i]['name'] = $provincia->nombre;
                $data[$i]['parent'] = (string)$provincia->id_region;
                $data[$i]['value'] = (int)$provincia->cantidad;
                $i++;
            }
        }

        for ($k = 1; $k <= 24; $k ++) {
            $matriz_aux = [];
            $codigos = Ceb001::where('periodo', $periodo)
            ->where('p.id_provincia', str_pad($k, 2, '0', STR_PAD_LEFT))
            ->join('geo.provincias as p', 'c001.id_provincia', '=', 'p.id_provincia')
            ->join('geo.regiones as r', 'p.id_region', '=', 'r.id_region')
            ->join('pss.codigos as cg', 'c001.codigo_prestacion', '=', 'cg.codigo_prestacion')
            ->select('r.id_region', 'p.id_provincia', 'c001.codigo_prestacion', 'cg.descripcion_grupal', DB::raw('sum(cantidad) as cantidad'))
            ->groupBy('r.id_region')
            ->groupBy('p.id_provincia')
            ->groupBy('c001.codigo_prestacion')
            ->groupBy('cg.descripcion_grupal')
            ->orderBy(DB::raw('sum(cantidad)'), 'desc')
            ->take(15)
            ->get();
            foreach ($codigos as $key => $codigo) {
                $matriz_aux[] = $codigo->codigo_prestacion;
                $data[$i]['id'] = $codigo->id_region . "_" . $codigo->id_provincia . "_" . $codigo->codigo_prestacion;
                $data[$i]['name'] = $codigo->codigo_prestacion;
                $data[$i]['parent'] = $codigo->id_region . "_" . $codigo->id_provincia;
                $data[$i]['value'] = (int)$codigo->cantidad;
                $data[$i]['texto_prestacion'] = $codigo->descripcion_grupal;
                $data[$i]['codigo_prestacion'] = true;
                $i++;
            }

            for ($l = 0; $l < count($matriz_aux); $l ++) {
                $grupos = Ceb001::where('periodo', $periodo)
                ->where('p.id_provincia', str_pad($k, 2, '0', STR_PAD_LEFT))
                ->where('codigo_prestacion', $matriz_aux[$l])
                ->join('geo.provincias as p', 'c001.id_provincia', '=', 'p.id_provincia')
                ->join('geo.regiones as r', 'p.id_region', '=', 'r.id_region')
                ->join('pss.grupos_etarios as g', 'c001.grupo_etario', '=', 'g.sigla')
                ->select('r.id_region', 'p.id_provincia', 'c001.codigo_prestacion', 'g.descripcion', DB::raw('sum(cantidad) as cantidad'))
                ->groupBy('r.id_region')
                ->groupBy('p.id_provincia')
                ->groupBy('c001.codigo_prestacion')
                ->groupBy('g.descripcion')
                ->get();
                foreach ($grupos as $key => $grupo) {
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
     * Devuelve la info para el gráfico 3
     *
     * @return json
     */
    public function getGrafico3($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');
        
        foreach ($data['categorias'] as $key => $provincia) {
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = Fc009::select('id_provincia', DB::raw('(sum(cantidad_dr) / sum(cantidad_total_dr)) * 100 as c'))
        ->join('pss.codigos_datos_reportables as dr', 'dr.codigo_prestacion', '=', 'estadisticas.fc_009.codigo_prestacion')
        ->where('periodo', $periodo)
        ->groupBy('id_provincia')
        ->orderBy('id_provincia')
        ->get();

        for ($i=0; $i < 24; $i++) {
            $data['series'][0]['data'][$i] = 0;
        }
        foreach ($prestaciones as $key => $prestacion) {
            $data['series'][0]['name'] = 'Porcentaje de prestaciones con datos reportables';
            $data['series'][0]['data'][((int) $prestacion->id_provincia) - 1] = (float) number_format($prestacion->c, 2);
        }

        return response()->json($data);
    }

    /**
     * Devuelve JSON para la datatable
     *
     * @return json
     */
    public function getGrafico3Tabla($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $prestaciones = Fc009::select('id_provincia', 'dr.codigo_prestacion', 'cantidad_dr', 'cantidad_total_dr')
        ->join('pss.codigos_datos_reportables as dr', 'dr.codigo_prestacion', '=', 'estadisticas.fc_009.codigo_prestacion')
        ->where('periodo', $periodo)
        ->orderBy('id_provincia')
        ->orderBy('dr.codigo_prestacion');
        
        return Datatables::of($prestaciones)->make(true);
    }

    /**
     * Devuelve JSON para el grafico de stack
     *
     * @return json
     */
    public function getGrafico3Dr($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');

        foreach ($data['categorias'] as $key => $provincia) {
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = Fc009::select(DB::raw('id_provincia,sum(cantidad_total_dr) as a,sum(cantidad_total_dr - cantidad_dr) as b'))
        ->where('periodo', $periodo)
        ->groupBy('id_provincia')
        ->get();

        for ($i=0; $i < 24; $i++) {
            $data['series'][0]['data'][$i] = 0;
            $data['series'][1]['data'][$i] = 0;
        }
        foreach ($prestaciones as $key => $prestacion) {
            $data['series'][0]['name'] = 'Prestaciones que requieren dr';
            $data['series'][0]['color'] = '#069001';
            $data['series'][0]['data'][((int) $prestacion->id_provincia) - 1] = (int) $prestacion->a;
            $data['series'][1]['name'] = 'No presentan dr';
            $data['series'][1]['color'] = '#ba140b';
            $data['series'][1]['data'][((int) $prestacion->id_provincia) - 1] = (int) $prestacion->b;
        }

        return response()->json($data);
    }

    /**
     * Calcula los datos reportables por lote en vez de fecha de prestacion
     *
     * @return json
     */
    public function getGrafico3DrLote($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');

        foreach ($data['categorias'] as $key => $provincia) {
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = DB::table("temporales.estadisticasdr as dr")
        ->select('periodo',"id_provincia", DB::raw("sum(requiere_dr) as a,sum(requiere_dr - tiene_dr) as b"))
        ->where('periodo', $periodo)
        ->groupBy('periodo','id_provincia')
        ->orderBy('id_provincia')
        ->get();

        for ($i=0; $i < 24; $i++) {
            $data['series'][0]['data'][$i] = 0;
            $data['series'][1]['data'][$i] = 0;
        }

        foreach ($prestaciones as $key => $prestacion) {
            $data['series'][0]['name'] = 'Prestaciones que requieren dr';
            $data['series'][0]['color'] = '#069001';
            $data['series'][0]['data'][((int) $prestacion->id_provincia) - 1] = (int) $prestacion->a;
            $data['series'][1]['name'] = 'No presentan dr';
            $data['series'][1]['color'] = '#ba140b';
            $data['series'][1]['data'][((int) $prestacion->id_provincia) - 1] = (int) $prestacion->b;
        }

        return response()->json($data);
    }

    /**
     * Calcula los datos reportables por lote en vez de fecha de prestacion
     *
     * @return json
     */
    public function getGrafico3DrLote2($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');

        foreach ($data['categorias'] as $key => $provincia) {
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = DB::table("temporales.estadisticasdr as dr")
        ->select('periodo',"id_provincia", DB::raw("sum(tiene_dr) as a,sum(requiere_dr - tiene_dr) as b, sum(requiere_dr) as c"))
        ->where('periodo', $periodo)
        ->groupBy('periodo','id_provincia')
        ->orderBy('id_provincia')
        ->get();

        $data['series'][0]['name'] = "Tiene DR";
        $data['series'][0]['color'] = '#069001';
        $data['series'][1]['name'] = "No tiene DR";
        $data['series'][1]['color'] = '#ba140b';

        foreach ($prestaciones as $prestacion){
            $data['series'][0]['data'][] = (int) $prestacion->a;
            $data['series'][1]['data'][] = (int) $prestacion->b;
        }

        return response()->json($data);
    }

    /**
     * Retorna la información para armar el gráfico complicado
     *
     * @return json
     */
    public function getDistribucionGrafico3($periodo)
    {
        $periodo = str_replace("-", '', $periodo);
        $i = 0;
        $regiones = Fc009::where('periodo', $periodo)
        ->join('geo.provincias as p', 'estadisticas.fc_009.id_provincia', '=', 'p.id_provincia')
        ->join('geo.regiones as r', 'p.id_region', '=', 'r.id_region')
        ->join('pss.codigos_datos_reportables as dr', 'dr.codigo_prestacion', '=', 'estadisticas.fc_009.codigo_prestacion')
        ->select('r.id_region', 'r.nombre', DB::raw('sum(cantidad_dr) as cantidad'))
        ->groupBy('r.id_region')
        ->groupBy('r.nombre')
        ->get();
        foreach ($regiones as $key => $region) {
            $data[$i]['color'] = $this->alter_brightness('#0F467F', $key * 35);
            $data[$i]['id'] = (string)$region->id_region;
            $data[$i]['name'] = $region->nombre;
            $data[$i]['value'] = (int)$region->cantidad;
            $i++;
        }

        for ($j = 0; $j <= 5; $j ++) {
            $provincias = Fc009::where('periodo', $periodo)
            ->where('r.id_region', $j)
            ->join('geo.provincias as p', 'estadisticas.fc_009.id_provincia', '=', 'p.id_provincia')
            ->join('geo.regiones as r', 'p.id_region', '=', 'r.id_region')
            ->join('pss.codigos_datos_reportables as dr', 'dr.codigo_prestacion', '=', 'estadisticas.fc_009.codigo_prestacion')
            ->select('r.id_region', 'p.id_provincia', 'p.nombre', DB::raw('sum(cantidad_dr) as cantidad'))
            ->groupBy('r.id_region')
            ->groupBy('p.id_provincia')
            ->groupBy('p.nombre')
            ->get();
            foreach ($provincias as $key => $provincia) {
                $data[$i]['id'] = $provincia->id_region . "_" . $provincia->id_provincia;
                $data[$i]['name'] = $provincia->nombre;
                $data[$i]['parent'] = (string)$provincia->id_region;
                $data[$i]['value'] = (int)$provincia->cantidad;
                $i++;
            }
        }

        for ($k = 1; $k <= 24; $k ++) {
            $matriz_aux = [];
            $codigos = Fc009::where('periodo', $periodo)
            ->where('p.id_provincia', str_pad($k, 2, '0', STR_PAD_LEFT))
            ->join('geo.provincias as p', 'estadisticas.fc_009.id_provincia', '=', 'p.id_provincia')
            ->join('geo.regiones as r', 'p.id_region', '=', 'r.id_region')
            ->join('pss.codigos_datos_reportables as dr', 'dr.codigo_prestacion', '=', 'estadisticas.fc_009.codigo_prestacion')
            ->select('r.id_region', 'p.id_provincia', 'estadisticas.fc_009.codigo_prestacion', DB::raw('sum(cantidad_dr) as cantidad'))
            ->groupBy('r.id_region')
            ->groupBy('p.id_provincia')
            ->groupBy('estadisticas.fc_009.codigo_prestacion')
            ->orderBy(DB::raw('sum(cantidad_dr)'), 'desc')
            ->take(5)
            ->get();
            foreach ($codigos as $key => $codigo) {
                $matriz_aux[] = $codigo->codigo_prestacion;
                $data[$i]['id'] = $codigo->id_region . "_" . $codigo->id_provincia . "_" . $codigo->codigo_prestacion;
                $data[$i]['name'] = $codigo->codigo_prestacion;
                $data[$i]['parent'] = $codigo->id_region . "_" . $codigo->id_provincia;
                $data[$i]['value'] = (int)$codigo->cantidad;
                $data[$i]['texto_prestacion'] = $codigo->codigo_prestacion;
                $data[$i]['codigo_prestacion'] = true;
                $i++;
            }
        }
        return response()->json($data);
    }

    /**
     * Devuelve la información para armar el gráfico 4
     * @param string $periodo
     *
     * @return null
     */
    public function getGrafico4($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $data['categorias'] = [
            '0-5','6-9','10-19','20-64'
        ];

        $rangos = [
            [
                'min' => 0,
                'max' => 5,
            ],
            [
                'min' => 6,
                'max' => 9
            ],
            [
                'min' => 10,
                'max' => 19
            ],
            [
                'min' => 20,
                'max' => 64
            ]
        ];

        foreach ($rangos as $rango) {
            $sexos = Fc004::select('sexo', DB::raw('sum(cantidad) as c'))
            ->whereIn('sexo', ['M','F'])
            ->whereBetween('edad', [$rango['min'],$rango['max']])
            ->groupBy('sexo')
            ->orderBy('sexo')
            ->get();

            $data['series'][0]['name'] = 'Hombres';
            $data['series'][1]['name'] = 'Mujeres';

            foreach ($sexos as $sexo) {
                if ($sexo->sexo == 'M') {
                    $data['series'][0]['data'][] = (int)(-$sexo->c/1000);
                    $data['series'][0]['color'] = '#3c8dbc';
                } else {
                    $data['series'][1]['data'][] = (int)($sexo->c/1000);
                    $data['series'][1]['color'] = '#D81B60';
                }
            }
        }

        return response()->json($data);
    }

    /**
     * Devuelve JSON para la datatable
     *
     * @return json
     */
    public function getGrafico4Tabla($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $prestaciones = Fc004::where('periodo', $periodo);

        if (Auth::user()->id_entidad == 2) {
            $prestaciones->where('id_provincia', Auth::user()->id_provincia)->get();
        } else {
            $prestaciones->get();
        }

        return Datatables::of($prestaciones)->make(true);
    }

    /**
     * Devuelve la información para armar el gráfico 5
     * @param string $periodo
     *
     * @return null
     */
    public function getGrafico5($periodo)
    {
        $periodo = str_replace("-", '', $periodo);
        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');
        
        foreach ($data['categorias'] as $key => $provincia) {
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = Fc002::join('pss.codigos_priorizadas as p', 'estadisticas.fc_002.codigo_prestacion', '=', 'p.codigo_prestacion')
        ->select('id_provincia', DB::raw('sum(cantidad) as c'), DB::raw('sum(monto) as m'))
        ->where('periodo', $periodo)
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
     * @return json
     */
    public function getGrafico5Tabla($periodo)
    {
        $periodo = str_replace("-", '', $periodo);

        $prestaciones = Fc002::join('pss.codigos_priorizadas as p', 'estadisticas.fc_002.codigo_prestacion', '=', 'p.codigo_prestacion')
        ->where('periodo', $periodo);

        if (Auth::user()->id_entidad == 2) {
            $prestaciones->where('id_provincia', Auth::user()->id_provincia)->get();
        } else {
            $prestaciones->get();
        }

        return Datatables::of($prestaciones)->make(true);
    }

    /**
     * Devuelve la info para el gráfico 6
     *
     * @return json
     */
    public function getGrafico6()
    {
        $data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');
        
        foreach ($data['categorias'] as $key => $provincia) {
            $data['categorias'][$key] = ucwords(mb_strtolower($provincia));
        }

        $prestaciones = Fc001::select('id_provincia', DB::raw('sum(cantidad) as c'))
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
     * @return json
     */
    public function getGrafico7Tabla($periodo, $provincia)
    {
        $periodo = str_replace("-", '', $periodo);

        $prestaciones = Fc008::select('periodo_prestacion', 'codigo_prestacion', 'cantidad')
        ->where('periodo', $periodo)
        ->where('id_provincia', $provincia);

        return Datatables::of($prestaciones)->make(true);
    }

    /**
     * Devuelve la info para el gráfico 7
     *
     * @return json
     */
    public function getGrafico7($periodo, $provincia)
    {
        $periodo = str_replace("-", '', $periodo);
        $categorias = Fc008::select('periodo_prestacion')
        ->where('periodo', $periodo)
        ->where('id_provincia', $provincia)
        ->groupBy('periodo_prestacion')
        ->orderBy('periodo_prestacion')
        ->get();

        foreach ($categorias as $categoria) {
            $meses[] = $categoria->periodo_prestacion;
        }

        $data['categorias'] = $this->getFormatMeses($meses);

        
        $prestaciones = Fc008::select('periodo_prestacion', DB::raw('sum(cantidad) as c'))
        ->where('periodo', $periodo)
        ->where('id_provincia', $provincia)
        ->groupBy('periodo_prestacion')
        ->orderBy('periodo_prestacion')
        ->get();

        foreach ($prestaciones as $key => $prestacion) {
            $data['series'][0]['name'] = 'Prestaciones reportadas en ' . $periodo;
            $data['series'][0]['data'][] = (int) $prestacion->c;
        }

        return response()->json($data);
    }

    /**
     * Devuelve JSON para la datatable
     *
     * @return json
     */
    public function getGrafico6Tabla()
    {
        $prestaciones = Fc001::join('geo.provincias as p', 'estadisticas.fc_001.id_provincia', '=', 'p.id_provincia');
        return Datatables::of($prestaciones)->make(true);
    }

    /**
     * Devuelve listado de 12 meses
     *
     * @return json
     */
    protected function getFormatMeses($meses)
    {

        foreach ($meses as $mes) {
            $dt = \DateTime::createFromFormat('Ym', $mes);
            $array_meses[] = strftime("%b %Y", $dt->getTimeStamp());
        }
        
        return $array_meses;
    }
}
