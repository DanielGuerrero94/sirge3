<?php

namespace App\Http\Controllers;

use DB;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;
use App\Models\Dw\CEB\Ceb001;
use App\Models\Dw\CEB\Ceb002;
use App\Models\Dw\CEB\Ceb003;
use App\Models\Dw\CEB\Ceb004;
use App\Models\Dw\CEB\Ceb005;
use App\Models\Dw\FC\Fc001;
use App\Models\TareasResultado;

class ComponentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /** 
     * Devuelve la vista del resumen de O.D.P 1
     * @param string $periodo
     *
     * @return null
     */
    public function getResumenODP1($periodo = null){
        if(isset($periodo)){
            $dt = \DateTime::createFromFormat('Y-m' , $periodo);    
        }
        else{
            $dt = new \DateTime();
            //$dt->modify('-1 month');           
            $periodo = $dt->format('Ym');
        }

        $data = [
            'page_title' => 'Resumen mensual O.D.P 1, ' . ucwords(strftime("%B %Y" , $dt->getTimeStamp())),
            /*'progreso_ceb_series' => $this->getProgresoCeb($periodo),
            'progreso_ceb_categorias' => $this->getMesesArray($periodo),
            'distribucion_provincial_categorias' => $this->getProvinciasArray(),
            'distribucion_provincial_series' => $this->getDistribucionProvincial($periodo),*/
            'map' => $this->getMapSeries(),
            'treemap_data' => $this->getDistribucionCodigos($periodo),
            'pie_ceb' => $this->getDistribucionCeb($periodo),
            'pie_ceb_hombres' => $this->getDistribucionCebHombres($periodo),
            'distribucion_sexos' => $this->getSexosSeries($periodo),
            'periodo_calculado' => $periodo
        ];

        return view('componentes.odp1' , $data);
    }

     /**
     * Devuelve la info para el grafico de torta
     * @param string $periodo
     *
     * @return json
     */
    protected function getDistribucion($provincia = null){

        $dt = new \DateTime();
        //$dt->modify('-1 month');           
        $periodo = $dt->format('Ym');

        $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;
        
        $periodo = str_replace("-", '', $periodo);
        $grupos = Ceb003::select(DB::raw('substring(grupo_etario from 1 for 1) as name') , DB::raw('sum(cantidad)::int as y'))
                        ->where('periodo' , $periodo)
                        ->groupBy(DB::raw(1))
                        ->orderBy(DB::raw(1))
                        ->get();
        
        return json_encode($grupos);
    }

    /**
     * Retorna la información para armar el gráfico complicado
     *
     * @return json
     */
    public function getDistribucionCodigos($provincia = null){                

        $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;

        $i = 0;
        $regiones = Ceb003::where('periodo' , $periodo)
                        ->join('geo.provincias as p' , 'c003.id_provincia' , '=' , 'p.id_provincia')
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
            $provincias = Ceb003::where('periodo' , $periodo)
                            ->where('r.id_region' , $j)
                            ->join('geo.provincias as p' , 'c003.id_provincia' , '=' , 'p.id_provincia')
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
            $codigos = Ceb003::where('periodo' , $periodo)
                            ->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
                            ->join('geo.provincias as p' , 'c003.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->join('pss.codigos as cg' , 'c003.codigo_prestacion' , '=' , 'cg.codigo_prestacion')
                            ->select('r.id_region' , 'p.id_provincia' , 'c003.codigo_prestacion' , 'cg.descripcion_grupal' , DB::raw('sum(cantidad) as cantidad'))
                            ->groupBy('r.id_region')
                            ->groupBy('p.id_provincia')
                            ->groupBy('c003.codigo_prestacion')
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
                $grupos = Ceb003::where('periodo' , $periodo)
                                ->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
                                ->where('codigo_prestacion' , $matriz_aux[$l])
                                ->join('geo.provincias as p' , 'c003.id_provincia' , '=' , 'p.id_provincia')
                                ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                                ->join('pss.grupos_etarios as g' , 'c003.grupo_etario' , '=' , 'g.sigla')
                                ->select('r.id_region' , 'p.id_provincia' , 'c003.codigo_prestacion' , 'g.descripcion' , DB::raw('sum(cantidad) as cantidad'))
                                ->groupBy('r.id_region')
                                ->groupBy('p.id_provincia')
                                ->groupBy('c003.codigo_prestacion')
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
     * Devuelve la info para el grafico de torta para beneficiarios hombres de 20-64
     * @param string $periodo
     *
     * @return json
     */
    protected function getDistribucionCebHombres($periodo = null, $provincia = null){
        
        $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;
        
        $object = Ceb004::select(DB::raw('sum(beneficiarios_activos) as y'))->where('periodo',$periodo);
        if(isset($provincia)){
            $object->where('id_provincia',$provincia);
        }        
        
        $meta = 7;        

        $cantidad_total = $object->first()->y;

        $cantidad_para_cumplir = round($object->first()->y * $meta / 100);
                
        $object = Ceb004::select(DB::raw('sum(beneficiarios_ceb) as y'))->where('periodo',$periodo);
        if(isset($provincia)){
            $object->where('id_provincia',$provincia);
        }

        $cantidad_cumplida = round($object->first()->y);

        $data[] = array_merge(array('y' => $cantidad_total - $cantidad_para_cumplir), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));    
        }
        else{
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));       
        }

        $data[] = array_merge($object->first()->toArray(),array('name' => 'ceb', 'color' => '#00FFFF'));        

        $superObjeto = [
                        'titulo' => 'Meta: '. $meta . '%',
                        'data' => json_encode($data) 
                        ];

        return $superObjeto;
    }

    /**
     * Devuelve la info para el grafico de torta para beneficiarios sin hombres de 20-64
     * @param string $periodo
     *
     * @return json
     */
    protected function getDistribucionCeb($periodo = null, $provincia = null){
        
        $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;
        
        $object = Ceb005::select(DB::raw('sum(beneficiarios_activos) as y'))->where('periodo',$periodo);
        if(isset($provincia)){
            $object->where('id_provincia',$provincia);
        }        
        
        $meta = 45;        

        $cantidad_total = $object->first()->y;

        $cantidad_para_cumplir = round($object->first()->y * $meta / 100);
                
        $object = Ceb005::select(DB::raw('sum(beneficiarios_ceb) as y'))->where('periodo',$periodo);
        if(isset($provincia)){
            $object->where('id_provincia',$provincia);
        }

        $cantidad_cumplida = round($object->first()->y);

        $data[] = array_merge(array('y' => $cantidad_total - $cantidad_para_cumplir), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));    
        }
        else{
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));       
        }

        $data[] = array_merge($object->first()->toArray(),array('name' => 'ceb', 'color' => '#00FFFF'));        

        $superObjeto = [
                        'titulo' => 'Meta: '. $meta . '%',
                        'data' => json_encode($data) 
                        ];
     
        return $superObjeto;
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
     * Devuelve la info para el gráfico por sexo
     * @param string $periodo
     *
     * @return json
     */
    protected function getSexosSeries($periodo = null){
        
        $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;

        $grupos = ['A','B','C','D'];

        foreach ($grupos as $grupo) {

            $sexos = Ceb003::where('periodo' , $periodo)
                            ->where('grupo_etario' , $grupo)
                            ->whereIn('sexo',['M','F'])
                            ->select('sexo' , DB::raw('sum(cantidad) as c'))
                            ->groupBy('sexo')
                            ->orderBy('sexo')
                            ->get();

            $data[0]['name'] = 'Hombres';
            $data[1]['name'] = 'Mujeres';

            foreach ($sexos as $sexo){

                if ($sexo->sexo == 'M'){
                    $data[0]['data'][] = (int)(-$sexo->c);
                    $data[0]['color'] = '#3c8dbc';
                } else {
                    $data[1]['data'][] = (int)($sexo->c);
                    $data[1]['color'] = '#D81B60';
                }
            }
        }

        return json_encode($data);
    }

    /**
     * Devuelve la información para graficar los mapas
     * @param int $periodo 
     * @param int $linea
     *
     * @return array
     */
    protected function getMapSeries($periodo = null, $provincia = null){

        $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;

        $provincias = Ceb002::where('periodo' , $periodo)->groupBy('id_provincia')->orderBy('id_provincia' , 'desc')->lists('id_provincia');
        

        $resultados = Ceb002::join('geo.geojson as g' , 'estadisticas.ceb_002.id_provincia' , '=' , 'g.id_provincia')
                                ->where('periodo' , $periodo)                                
                                ->orderBy('estadisticas.ceb_002.id_provincia' , 'asc')
                                ->get();

        //return '<pre>' . json_encode($resultados , JSON_PRETTY_PRINT) . '</pre>';

        foreach ($resultados as $key_provincia => $resultado){
            
            $map['map-data'][$key_provincia]['value'] = $resultado->beneficiarios_ceb;            
            $map['map-data'][$key_provincia]['hc-key'] = $resultado->codigo;            
            $map['map-data'][$key_provincia]['periodo'] = $periodo;
            $map['map-data'][$key_provincia]['provincia'] = $resultado->id_provincia;
        }

        $map['map-data'] = json_encode($map['map-data']);
        $map['clase'] = $key_provincia;        

        return $map;
    }

    /**
     * Devuelve un pequeño detalle del indicador para una provincia y un período
     * @param int $periodo
     * @param int $indicador
     * @param char $provincia
     *
     * @return null
     */
    public function getDetalleProvincia($periodo = null, $provincia = null){

        $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;

        $resultado = Ceb004::where('periodo' , $periodo);

        if(isset($provincia)){
            $resultado->where('id_provincia' , $provincia)
            ->groupBy('id_provincia');            

            $provincia = Provincia::find($provincia);
            $data['A']['entidad'] =  $provincia->descripcion;                      
        }
        else{
            $resultado->select(DB::raw('sum(beneficiarios_registrados) as beneficiarios_registrados'),DB::raw('sum(beneficiarios_activos) as beneficiarios_activos'),DB::raw('sum(beneficiarios_ceb) as beneficiarios_ceb'));
            $data['A']['entidad'] =  'País'; 
        }

        $resultado = $resultado->first();        

        $data['A']['titulo'] = 'Niños, adolescentes y mujeres adultas';
        $data['A']['periodo'] = $periodo;
        $data['A']['beneficiarios_registrados'] = number_format($resultado->beneficiarios_registrados);
        $data['A']['beneficiarios_activos'] = number_format($resultado->beneficiarios_activos);
        $data['A']['beneficiarios_ceb'] = number_format($resultado->beneficiarios_ceb);
        $data['A']['porcentaje_actual'] = round($resultado->beneficiarios_ceb / $resultado->beneficiarios_activos , 2) * 100;

        $resultado = Ceb005::where('periodo' , $periodo);

        if(isset($provincia)){
            $resultado->where('id_provincia' , $provincia)
            ->groupBy('id_provincia');            

            $provincia = Provincia::find($provincia);
            $data['B']['entidad'] =  $provincia->descripcion;                      
        }
        else{
            $resultado->select(DB::raw('sum(beneficiarios_registrados) as beneficiarios_registrados'),DB::raw('sum(beneficiarios_activos) as beneficiarios_activos'),DB::raw('sum(beneficiarios_ceb) as beneficiarios_ceb'));
            $data['B']['entidad'] =  'País'; 
        }

        $resultado = $resultado->first();

        $data['B']['titulo'] = 'Hombres adultos';
        $data['B']['periodo'] = $periodo;   
        $data['B']['beneficiarios_registrados'] = number_format($resultado->beneficiarios_registrados);
        $data['B']['beneficiarios_activos'] = number_format($resultado->beneficiarios_activos);
        $data['B']['beneficiarios_ceb'] = number_format($resultado->beneficiarios_ceb);
        $data['B']['porcentaje_actual'] = round($resultado->beneficiarios_ceb / $resultado->beneficiarios_activos , 2) * 100;   

        //return var_dump(array('data' => json_encode($data)));

        return view('componentes.ceb-detalle-provincia' , array('data' => $data));
    }
}
