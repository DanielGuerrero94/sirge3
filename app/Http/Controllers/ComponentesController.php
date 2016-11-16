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
use App\Models\ODP\OdpTipo;
use App\Models\ODP\MetaDescripcion;
use App\Models\ODP\MetaResultado;
use App\Models\ODP\MetaTipo;
use App\Models\Geo\Region;

class ComponentesController extends Controller
{
    /** 
     * Devuelve la vista del resumen de O.D.P 1
     * @param string $periodo
     *
     * @return null
     */
    public function getResumenODP1($periodo = null, $provincia = null){
       /* $periodo = 201601;
        $provincia = '05';*/

        if(isset($periodo)){
            $dt = \DateTime::createFromFormat('Y-m' , substr($periodo, 0,4) . '-' . substr($periodo, 4,2));
            $periodo = $dt->format('Ym');    
        }
        else{
            $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;
            $dt = \DateTime::createFromFormat('Y-m' , substr($periodo, 0,4) . '-' . substr($periodo, 4,2));                
        }

        if(! isset($provincia)){
            $provincia = null;
            $provincia_descripcion = 'Nivel Pais';
        }
        else{
            $datos_provincia = Provincia::find($provincia);            
            $provincia_descripcion =  $datos_provincia->descripcion;
        }

        //return var_dump($this->getDistribucionCebPais($periodo));

        $data = [
            'page_title' => 'Resumen mensual O.D.P 1, '.$provincia_descripcion.', '. date('Y'),
            /*'progreso_ceb_series' => $this->getProgresoCeb($periodo),
            'progreso_ceb_categorias' => $this->getMesesArray($periodo),
            'distribucion_provincial_categorias' => $this->getProvinciasArray(),
            'distribucion_provincial_series' => $this->getDistribucionProvincial($periodo),*/
            'map' => $this->getMapSeries($periodo),
            //'treemap_data' => $this->getDistribucionCodigos($periodo,$provincia),
            'pie_ceb' => isset($provincia) ? $this->getDistribucionCeb($periodo,$provincia) : $this->getDistribucionCebPais($periodo),
            'pie_ceb_hombres' => isset($provincia) ? $this->getDistribucionCebHombres($periodo,$provincia) : $this->getDistribucionCebHombresPais($periodo),
            //'distribucion_sexos' => $this->getSexosSeries($periodo,$provincia),
            'periodo_calculado' => $periodo,
            'provincia' => $provincia == null ? 'pais' : $provincia,
            'provincia_descripcion' => $provincia_descripcion
        ];

        return view('componentes.odp1' , $data);
    }

    /** 
     * Devuelve la vista del resumen de O.D.P 1
     * @param string $periodo
     *
     * @return null
     */
    public function getResumenODP2($periodo = null, $provincia = null){
       /* $periodo = 201601;
        $provincia = '05';*/

        if(isset($periodo)){
            $dt = \DateTime::createFromFormat('Y-m' , substr($periodo, 0,4) . '-' . substr($periodo, 4,2));
            $periodo = $dt->format('Ym');    
        }
        else{
            $periodo = TareasResultado::select(DB::raw('max(periodo)'))->first()->max;
            $dt = \DateTime::createFromFormat('Y-m' , substr($periodo, 0,4) . '-' . substr($periodo, 4,2));                
        }

        if(! isset($provincia)){
            $provincia = null;
            $provincia_descripcion = 'Nivel Pais';
        }
        else{
            $datos_provincia = Provincia::find($provincia);            
            $provincia_descripcion =  $datos_provincia->descripcion;
        }        

        $data = [
            'page_title' => 'Resumen mensual O.D.P 2, '.$provincia_descripcion.', '. date('Y'),
            /*'progreso_ceb_series' => $this->getProgresoCeb($periodo),
            'progreso_ceb_categorias' => $this->getMesesArray($periodo),
            'distribucion_provincial_categorias' => $this->getProvinciasArray(),
            'distribucion_provincial_series' => $this->getDistribucionProvincial($periodo),*/
            'map' => $this->getMapSeries($periodo),
            'pie_cp' => $this->getDistribucionCp($periodo,$provincia),            
            //'distribucion_sexos' => $this->getSexosSeries($periodo,$provincia),
            'periodo_calculado' => $periodo,
            'provincia' => $provincia == null ? 'pais' : $provincia,
            'provincia_descripcion' => $provincia_descripcion
        ];

        return view('componentes.odp2' , $data);
    }

    /**
     * Retorna la información para armar el gráfico complicado
     *
     * @return json
     */
    public function getDistribucionCodigos($periodo, $provincia = null){                

        $data = [];

        if(! isset($provincia)){        
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
        }
        else{

            $i = 0;
            $matriz_aux = [];            
            $codigos = Ceb003::where('periodo' , $periodo)
                            ->where('p.id_provincia' , $provincia)
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
                $data[$i]['id'] = $codigo->codigo_prestacion;
                $data[$i]['name'] = $codigo->codigo_prestacion;                
                $data[$i]['value'] = (int)$codigo->cantidad;
                $data[$i]['texto_prestacion'] = $codigo->descripcion_grupal;
                $data[$i]['codigo_prestacion'] = true;
                $i++;   
            }

            for ($l = 0 ; $l < count($matriz_aux) ; $l ++){
                $grupos = Ceb003::where('periodo' , $periodo)
                                ->where('p.id_provincia' , $provincia)
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
                    $data[$i]['id'] = $grupo->codigo_prestacion . "_" . $grupo->grupo_etario;
                    $data[$i]['name'] = $grupo->descripcion;
                    $data[$i]['parent'] = $grupo->codigo_prestacion;
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
    protected function getDistribucionCebHombres($periodo, $provincia = null){
        
        $meta = 7;

        $object = Ceb004::select(DB::raw('sum(beneficiarios_activos) as y'))->where('periodo',$periodo);        
        $object->where('id_provincia',$provincia);
                                        
        $cantidad_total = $object->first()->y;
        $cantidad_para_cumplir = round($object->first()->y * $meta / 100);
                
        $object = Ceb004::select(DB::raw('sum(beneficiarios_ceb) as y'))->where('periodo',$periodo);
        $object->where('id_provincia',$provincia);
    
        $cantidad_cumplida = round($object->first()->y);        

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => $cantidad_total - $cantidad_para_cumplir), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));
            $data[] = array_merge($object->first()->toArray(),array('name' => 'ceb', 'color' => '#00FFFF'));            
        }
        else{
            $data[] = array_merge(array('y' => $cantidad_total - $cantidad_cumplida), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir),array('name' => 'ceb', 'color' => '#00FFFF'));             
        }         

        $superObjeto = [
                        'titulo' => 'Meta: '. $meta . '%',
                        'data' => json_encode($data) 
                        ];

        return $superObjeto;
    }

     /**
     * Devuelve la info para el grafico de torta para beneficiarios hombres de 20-64
     * @param string $periodo
     *
     * @return json
     */
    protected function getDistribucionCebHombresPais($periodo, $provincia = null){
        
       $meta = 7;      
                        
        for ($i=1; $i < 25; $i++) {
            $object = Ceb004::select(DB::raw('sum(beneficiarios_activos) as y'))->where('periodo',$periodo);                 
            $object->where('id_provincia',str_pad($i, 2, "0", STR_PAD_LEFT));
            $cantidad_total[$i-1] = $object->first()->y;
        }        

        $cantidad_para_cumplir = $meta;
        
        for ($i=1; $i < 25; $i++) {                 
            $object = Ceb004::select(DB::raw('sum(beneficiarios_ceb) as y'))->where('periodo',$periodo);        
            $object->where('id_provincia',str_pad($i, 2, "0", STR_PAD_LEFT));
            $cantidad_cumplida_provincial[$i-1] = $object->first()->y;
        }              

        for ($i=1; $i < 25; $i++) {                             
            $resultados[$i-1] = round( $cantidad_cumplida_provincial[$i-1] / $cantidad_total[$i-1] , 4 );
        }

        $cantidad_cumplida = round( (array_sum($resultados) / count($resultados)) * 100 , 2);

        //return $cantidad_cumplida;  

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => 100 - $cantidad_para_cumplir), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_cumplida),array('name' => 'ceb', 'color' => '#00FFFF'));            
        }
        else{
            $data[] = array_merge(array('y' => 100 - $cantidad_cumplida), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir),array('name' => 'ceb', 'color' => '#00FFFF'));             
        }        

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
    protected function getDistribucionCeb($periodo, $provincia){
         
        $meta = 45;      
        
        $object = Ceb005::select(DB::raw('sum(beneficiarios_activos) as y'))->where('periodo',$periodo);        
        $object->where('id_provincia',$provincia);
        $cantidad_total = $object->first()->y;        

        $cantidad_para_cumplir = round( $cantidad_total * $meta / 100);
                
        $object = Ceb005::select(DB::raw('sum(beneficiarios_ceb) as y'))->where('periodo',$periodo);
        $object->where('id_provincia',$provincia);
        
        $cantidad_cumplida = round($object->first()->y);

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => $cantidad_total - $cantidad_para_cumplir), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));
            $data[] = array_merge($object->first()->toArray(),array('name' => 'ceb', 'color' => '#00FFFF'));            
        }
        else{
            $data[] = array_merge(array('y' => $cantidad_total - $cantidad_cumplida), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir),array('name' => 'ceb', 'color' => '#00FFFF'));             
        }        

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
    protected function getDistribucionCebPais($periodo){
         
        $meta = 45;      
                        
        for ($i=1; $i < 25; $i++) {
            $object = Ceb005::select(DB::raw('sum(beneficiarios_activos) as y'))->where('periodo',$periodo);                 
            $object->where('id_provincia',str_pad($i, 2, "0", STR_PAD_LEFT));
            $cantidad_total[$i-1] = $object->first()->y;
        }        

        $cantidad_para_cumplir = $meta;
        
        for ($i=1; $i < 25; $i++) {                 
            $object = Ceb005::select(DB::raw('sum(beneficiarios_ceb) as y'))->where('periodo',$periodo);        
            $object->where('id_provincia',str_pad($i, 2, "0", STR_PAD_LEFT));
            $cantidad_cumplida_provincial[$i-1] = $object->first()->y;
        }              

        for ($i=1; $i < 25; $i++) {                             
            $resultados[$i-1] = round( $cantidad_cumplida_provincial[$i-1] / $cantidad_total[$i-1] , 4 );
        }

        $cantidad_cumplida = round( (array_sum($resultados) / count($resultados)) * 100 , 2);

        //return $cantidad_cumplida;  

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => 100 - $cantidad_para_cumplir), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_cumplida),array('name' => 'ceb', 'color' => '#00FFFF'));            
        }
        else{
            $data[] = array_merge(array('y' => 100 - $cantidad_cumplida), array('name' => 'activos s/ceb', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir),array('name' => 'ceb', 'color' => '#00FFFF'));             
        }        

        $superObjeto = [
                        'titulo' => 'Meta: '. $meta . '%',
                        'data' => json_encode($data) 
                        ];
     
        return $superObjeto;
    }

    /**
     * Devuelve la info para el grafico de torta para beneficiarias embarazadas con control prenatal
     * @param string $periodo
     *
     * @return json
     */
    protected function getDistribucionCp($periodo, $provincia = null){
         
        $meta = 36;      
        
        $object = Ceb005::select(DB::raw('sum(beneficiarios_activos) as y'))->where('periodo',$periodo);
        if(isset($provincia)){
            $object->where('id_provincia',$provincia);
        }                
        $cantidad_total = $object->first()->y;
        $cantidad_para_cumplir = round($object->first()->y * $meta / 100);
                
        $object = Ceb005::select(DB::raw('sum(beneficiarios_ceb) as y'))->where('periodo',$periodo);
        if(isset($provincia)){
            $object->where('id_provincia',$provincia);
        }
        $cantidad_cumplida = round($object->first()->y);

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => $cantidad_total - $cantidad_para_cumplir), array('name' => 'sin control', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));
            $data[] = array_merge($object->first()->toArray(),array('name' => 'actual', 'color' => '#00FFFF'));            
        }
        else{
            $data[] = array_merge(array('y' => $cantidad_total - $cantidad_cumplida), array('name' => 'sin control', 'color' => '#DCDCDC'));
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir),array('name' => 'actual', 'color' => '#00FFFF'));             
        }        

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
    protected function getSexosSeries($periodo, $provincia = null){                

        $grupos = ['A','B','C','D'];

        foreach ($grupos as $grupo) {

            $sexos = Ceb003::where('periodo' , $periodo)
                            ->where('grupo_etario' , $grupo)
                            ->whereIn('sexo',['M','F'])
                            ->select('sexo' , DB::raw('sum(cantidad) as c'))
                            ->groupBy('sexo')
                            ->orderBy('sexo');
                            
            if(isset($provincia)){
                $sexos = $sexos->where('id_provincia', $provincia);
            }            
            
            $sexos = $sexos->get();

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
    protected function getMapSeries($periodo){        

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
    public function getDetalleProvincia($periodo, $provincia){        
       
        $dt = \DateTime::createFromFormat('Y-m' , substr($periodo, 0,4) . '-' . substr($periodo, 4,2));
        $periodo = $dt->format('Ym');               
        $resultado = Ceb005::where('periodo' , $periodo);

        if( $provincia != 'pais' ){
            $resultado = $resultado->where('id_provincia' , $provincia);                   

            $datos_provincia = Provincia::find($provincia);
            $data[0]['entidad'] =  $datos_provincia->descripcion;                      
        }
        else{
            $resultado = $resultado->select(DB::raw('sum(beneficiarios_registrados) as beneficiarios_registrados'),DB::raw('sum(beneficiarios_activos) as beneficiarios_activos'),DB::raw('sum(beneficiarios_ceb) as beneficiarios_ceb'));
            $data[0]['entidad'] =  'País'; 
        }

        $resultado = $resultado->first();        

        $data[0]['titulo'] = 'Niños, adolescentes y mujeres adultas';
        $data[0]['periodo'] = $periodo;
        $data[0]['beneficiarios_registrados'] = number_format($resultado->beneficiarios_registrados);
        $data[0]['beneficiarios_activos'] = number_format($resultado->beneficiarios_activos);
        $data[0]['beneficiarios_ceb'] = number_format($resultado->beneficiarios_ceb);
        $data[0]['indicador'] = '1.A';
        $data[0]['tipo'] = 'A';
        $data[0]['porcentaje_actual'] = round($resultado->beneficiarios_ceb / $resultado->beneficiarios_activos , 2) * 100;

        $resultado = Ceb004::where('periodo' , $periodo);

        if($provincia != 'pais'){
            $resultado = $resultado->where('id_provincia' , $provincia);
                       

            $datos_provincia = Provincia::find($provincia);
            $data[1]['entidad'] =  $datos_provincia->descripcion;                      
        }
        else{
            $resultado = $resultado->select(DB::raw('sum(beneficiarios_registrados) as beneficiarios_registrados'),DB::raw('sum(beneficiarios_activos) as beneficiarios_activos'),DB::raw('sum(beneficiarios_ceb) as beneficiarios_ceb'));
            $data[1]['entidad'] =  'País'; 
        }

        $resultado = $resultado->first();

        $data[1]['titulo'] = 'Hombres adultos';
        $data[1]['periodo'] = $periodo;   
        $data[1]['beneficiarios_registrados'] = number_format($resultado->beneficiarios_registrados);
        $data[1]['beneficiarios_activos'] = number_format($resultado->beneficiarios_activos);
        $data[1]['beneficiarios_ceb'] = number_format($resultado->beneficiarios_ceb);
        $data[1]['indicador'] = '1.B';
        $data[1]['tipo'] = 'B';
        $data[1]['porcentaje_actual'] = round($resultado->beneficiarios_ceb / $resultado->beneficiarios_activos , 2) * 100;   

        //return var_dump(array('data' => json_encode($data)));

        return view('componentes.ceb-detalle-provincia' , array('data' => $data));
    }

    /**
     * Devuelve un pequeño detalle del indicador para una provincia y un período
     * @param int $periodo
     * @param int $indicador
     * @param char $provincia
     *
     * @return null
     */
    public function getDetalleProvinciaODP2($periodo, $provincia){        
       
        $dt = \DateTime::createFromFormat('Y-m' , substr($periodo, 0,4) . '-' . substr($periodo, 4,2));
        $periodo = $dt->format('Ym');               
        $resultado = Ceb005::where('periodo' , $periodo);

        if( $provincia != 'pais' ){
            $resultado = $resultado->where('id_provincia' , $provincia);                   

            $datos_provincia = Provincia::find($provincia);
            $data['entidad'] =  $datos_provincia->descripcion;                      
        }
        else{
            $resultado = $resultado->select(DB::raw('sum(beneficiarios_registrados) as beneficiarios_registrados'),DB::raw('sum(beneficiarios_activos) as beneficiarios_activos'),DB::raw('sum(beneficiarios_ceb) as beneficiarios_ceb'));
            $data['entidad'] =  'País'; 
        }

        $resultado = $resultado->first();        

        $data['titulo'] = 'Control prenatal en embarazadas';
        $data['periodo'] = $periodo;
        $data['beneficiarios_registrados'] = number_format($resultado->beneficiarios_registrados);
        $data['beneficiarios_activos'] = number_format($resultado->beneficiarios_activos);
        $data['beneficiarios_ceb'] = number_format($resultado->beneficiarios_ceb);
        $data['indicador'] = '2';
        $data['tipo'] = 'B';
        $data['porcentaje_actual'] = round($resultado->beneficiarios_ceb / $resultado->beneficiarios_activos , 2) * 100;

        //return var_dump(array('data' => json_encode($data)));

        return view('componentes.ca-detalle-provincia' , array('data' => $data));
    }

    public function getEvolucionODP1($tipo){
        $dt = new \DateTime();
        $dt->modify('-1 month');
        $max = strftime("%b %Y" , $dt->getTimeStamp());
        $dt->modify('-4 months');
        $min = strftime("%b %Y" , $dt->getTimeStamp());

        $data = [
            'page_title' => 'Evolución: Período ' . $min . ' - ' . $max ,
            'series' => $this->getProgresionCebSeries($tipo)
        ];

        return view('componentes.evolucion' , $data);
    }

     /**
     * Devuelve la info para graficar
     * 
     * @return json
     */
    protected function getProgresionCebSeries($tipo){

        if($tipo == 'A'){
            $meta = 45;
            $clase = new Ceb005();
            $tabla = 'ceb_005';
        }
        else{
            $meta = 7;
            $clase = new Ceb004();   
            $tabla = 'ceb_004';
        }

        $dt = new \DateTime();
        $dt->modify('-1 month');

        $interval = $this->getDateInterval($dt->format('Y-m'));

        for ($i = 1 ; $i <= 5 ; $i ++){
            
            $datos = $clase::select('estadisticas.'.$tabla.'.*' , 'r.*')
                            ->join('geo.provincias as p' , 'estadisticas.'.$tabla.'.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->whereBetween('periodo' , [$interval['min'] , $interval['max']])
                            ->where('r.id_region' , $i)
                            ->orderBy('periodo')
                            ->orderBy('p.id_provincia')
                            ->get();

            foreach ($datos as $key => $registro) {
                $dateTime = \DateTime::createFromFormat('Ym' , $registro->periodo);
                $periodo_formato_mesano = strftime("%b %Y" , $dateTime->getTimeStamp());
                
                $series['regiones'][$i][$periodo_formato_mesano]['name'] = (string)$periodo_formato_mesano;
                $series['regiones'][$i][$periodo_formato_mesano]['data'][] = round(($registro->beneficiarios_ceb / $registro->beneficiarios_activos) * 100,2);
                $otrasSeries['regiones'][$i][$periodo_formato_mesano]['name'] = (string)$periodo_formato_mesano;
                $otrasSeries['regiones'][$i][$periodo_formato_mesano]['beneficiarios_ceb'][] = $registro->beneficiarios_ceb;
                $otrasSeries['regiones'][$i][$periodo_formato_mesano]['beneficiarios_activos'][] = $registro->beneficiarios_activos;                
            }                  
        }

        foreach ($series['regiones'] as $key => $serie){
            $final['regiones'][$key]['series'] = array_values($serie);
            $final['regiones'][$key]['elem'] = 'region'.$key;
            $final['regiones'][$key]['provincias'] = Provincia::where('id_region' , $key)->orderBy('id_provincia')->lists('descripcion');
        }

        foreach ($otrasSeries['regiones'] as $key => $serie) {            
            foreach ($serie as $key => $unaSerie) {
                $array_series[$unaSerie['name']][] = round(array_sum($unaSerie['beneficiarios_ceb']) / array_sum($unaSerie['beneficiarios_activos']) * 100 , 2);                
            }                        
        }

        foreach ($array_series as $key => $value) {
            $final['regiones'][6]['series'][] = array('name' => $key, 'data' => $value);    
        }

        for ($i=1; $i <= 5; $i++) { 
            for ($j=0; $j < Provincia::where('id_region' , $i)->count() ; $j++) {                 
                $values[] = $meta;
            }
           
            $final['regiones'][$i]['series'][] = array('name' => 'Meta', 'data' => $values,'type' => 'spline');
            $values = null;
        
        }

        

        $final['regiones'][6]['series'][] = array('type' => 'spline', 'name' => 'Meta', 'data' => array($meta,$meta,$meta,$meta,$meta));                
        $final['regiones'][6]['elem'] = 'region6';
        $final['regiones'][6]['provincias'] = Region::orderBy('id_region')->lists('descripcion');                       

        return json_decode(json_encode($final));
    }

    /**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
    protected function getDateInterval($periodo){

        $dt = \DateTime::createFromFormat('Y-m' , $periodo);
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-4 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

     /**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
    protected function getDescripcionIndicador($odp = null){                
        return view('componentes.descripcion-indicador');
    }

    /**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
    protected function cargarDatosODP(){                
        return view('componentes.alta');
    }

    /**
     * Devuelvo la vista para el alta de un componente de ODP
     *
     * @return null
     */
    public function getCarga(){
       /* $dependencias = DependenciaAdministrativa::where('id_dependencia_administrativa' , '<>' , 5)->get();
        $tipos = Tipo::where('id_tipo_efector' , '<>' , 8)->get();
        $categorias = Categoria::where('id_categorizacion' , '<>' , 10)->get();*/
        $provincias = Provincia::all();
        $odp = OdpTipo::all();
        $data = [
            'page_title' => 'Carga de Datos ODP',
            //'tipos' => $tipos,
            //'dependencias' => $dependencias,
            'odp' => $odp,
            'provincias' => $provincias
        ];

        return view('componentes.alta' , $data);
    }

    /**
     * Devuelvo la vista para el alta de un componente de ODP
     *
     * @return null
     */
    public function postCarga(Request $r){ 
                
        foreach ($r->all() as $key => $value) {
            return json_encode($key);            
        }        
        return json_encode(array($r->{'4'}, $r->{'5'}, $r->{'6'},$r->{'7'}, $r->indicador));               
    }

    /**
     * Devuelvo la vista para el formulario de planificacion y de observado de la provincia
     *
     * @return null
     */
    public function getFormularioMetasPlanificadas($id_meta, $provincia){ 
        
        $id_odp = OdpTipo::find($id_meta);

        $descripciones = MetaDescripcion::select('meta_desc_id','descripcion','meta_tipo','odp')->where('odp',$id_odp->odp)->whereIn('meta_tipo',[2,3,4])->groupBy(['meta_desc_id','descripcion','meta_tipo','odp'])->orderBy('meta_desc_id')->get();

        if(isset(MetaResultado::where('id_tipo_meta',$id_meta)
                    ->where('year',intval(date('Y')))
                    ->where('provincia',$provincia)                    
                    ->first()->detalle)){

            $detalle_resultados = json_decode(MetaResultado::where('id_tipo_meta',$id_meta)
                    ->where('year',intval(date('Y')))
                    ->where('provincia',$provincia)                    
                    ->first()->detalle);        
        }                    

        $columnas = 0;

        $año_anterior = date('Y', strtotime('-1 year'));        

        $html_view = '<div class="row">';
        
        foreach ($descripciones as $descripcion) {

            switch ($descripcion->meta_tipo) {
                    case 4:
                        $descripcion->descripcion = $descripcion->descripcion . ' ' . $año_anterior;
                        break;

                    case 3:
                        $descripcion->descripcion = $descripcion->descripcion . ' ' . date('Y');
                        break;
                    
                    default:
                        $descripcion->descripcion = $descripcion->descripcion;
                        break;
            }                        

            if(isset($detalle_resultados)){
                foreach ($detalle_resultados->campos as $resultado) {                  
                    if($resultado->id == $descripcion->meta_desc_id){                
                        $superObjeto[$descripcion->meta_desc_id] = array("id" => $descripcion->meta_desc_id, "valor" => $resultado->valor, "descripcion" => $descripcion->descripcion);                        
                    }                    
                }
            }            
            if(!isset($superObjeto[$descripcion->meta_desc_id])){
                $superObjeto[$descripcion->meta_desc_id] = array("id" => $descripcion->meta_desc_id, "descripcion" => $descripcion->descripcion);
            }
        }        
        
        foreach ($superObjeto as $unObjeto) {
                    
            if ($columnas == 2) {
                $html_view .= '</div>';
                $html_view .= '<br />';                                                                
                $html_view .= '<div class="row">';
                $columnas = 0;
            }

            $id_valor = isset($unObjeto['valor']) ? 'value="'.$unObjeto['valor'] .'"' : '';

            $html_view .= '<div class="col-md-6">
                                <div class="form-group">
                                    <label for="'.$unObjeto['id'].'" class="col-sm-4 control-label">'.$unObjeto['descripcion'].'</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="'.$unObjeto['id'].'" name="'.$unObjeto['id'].'" '.$id_valor.' placeholder="Rellene el campo">
                                    </div>
                                </div>
                            </div>';
            $columnas++;
        }
        $html_view .= '</div>';

        return $html_view;
    }

    /**
     * Devuelvo la vista para el formulario de planificacion y de observado de la provincia
     *
     * @return null
     */
    public function getFormularioMetasObservadas($id_meta, $provincia){

        $id_odp = OdpTipo::find($id_meta);

        $descripciones = MetaDescripcion::select('meta_desc_id','descripcion','meta_tipo','odp')->where('odp',$id_odp->odp)->where('meta_tipo',1)->groupBy(['meta_desc_id','descripcion','meta_tipo','odp'])->orderBy('meta_desc_id')->get();

        if(isset(MetaResultado::where('id_tipo_meta',$id_meta)
                    ->where('year',intval(date('Y')))
                    ->where('provincia',$provincia)                    
                    ->first()->detalle)){

            $detalle_resultados = json_decode(MetaResultado::where('id_tipo_meta',$id_meta)
                    ->where('year',intval(date('Y')))
                    ->where('provincia',$provincia)                    
                    ->first()->detalle);        
        }                    

        $columnas = 0;

        $html_view = '<div class="row">';
        
        foreach ($descripciones as $descripcion) {            
            
            switch ($descripcion->meta_tipo) {
                    case 4:
                        $descripcion->descripcion = $descripcion->descripcion . ' ' . $año_anterior;
                        break;

                    case 3:
                        $descripcion->descripcion = $descripcion->descripcion . ' ' . date('Y');
                        break;
                    
                    default:
                        $descripcion->descripcion = $descripcion->descripcion;
                        break;
            }

            if(isset($detalle_resultados)){
                foreach ($detalle_resultados->campos as $resultado) {                  
                    if($resultado->id == $descripcion->meta_desc_id){                
                        $superObjeto[$descripcion->meta_desc_id] = array("id" => $descripcion->meta_desc_id, "valor" => $resultado->valor, "descripcion" => $descripcion->descripcion);
                    }
                }
            }            
            if(!isset($superObjeto[$descripcion->meta_desc_id])){
                $superObjeto[$descripcion->meta_desc_id] = array("id" => $descripcion->meta_desc_id, "descripcion" => $descripcion->descripcion);
            }
        }        
        
        foreach ($superObjeto as $unObjeto) {
                    
            if ($columnas == 2) {
                $html_view .= '</div>';
                $html_view .= '<br />';                                                                
                $html_view .= '<div class="row">';
                $columnas = 0;
            }

            $id_valor = isset($unObjeto['valor']) ? 'value="'.$unObjeto['valor'] .'"' : '';

            $html_view .= '<div class="col-md-6">
                                <div class="form-group">
                                    <label for="'.$unObjeto['id'].'" class="col-sm-4 control-label">'.$unObjeto['descripcion'].'</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="'.$unObjeto['id'].'" name="'.$unObjeto['id'].'" '.$id_valor.' placeholder="Rellene el campo">
                                    </div>
                                </div>
                            </div>';
            $columnas++;
        }
        $html_view .= '</div>';

        return $html_view;    
    }
}
