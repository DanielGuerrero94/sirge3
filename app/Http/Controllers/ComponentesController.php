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
use App\Models\ODP\DescripcionODP;
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
    public function getResumenODP($odp, $provincia = null, $year = null){        
        $provincia = '03';
        
        if(isset($periodo)){
            $dt = \DateTime::createFromFormat('Y-m' , substr($periodo, 0,4) . '-' . substr($periodo, 4,2));
            $dt->modify('-2 months');
            $periodo = $dt->format('Ym');    
        }
        else{
            $dt = new \DateTime();        
            $dt->modify('-1 month');
            $periodo = $dt->format('Ym');             
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
            'page_title' => 'Resumen mensual O.D.P '. $odp.', '.$provincia_descripcion.', '. $dt->format('Y'),            
            'map' => $this->getMapSeries($odp),
            'pie_cp' => $this->getDistribucionCp($odp,$provincia),                        
            'periodo_calculado' => $periodo,
            'provincia' => $provincia == null ? 'pais' : $provincia,
            'provincia_descripcion' => $provincia_descripcion,
            'odp_descripcion' => $this->getDescripcionOdp($odp),
            'odp' => $odp
        ];

        return view('componentes.odp' , $data);
    }        

    /**
     * Devuelve la info para el grafico de torta para beneficiarias embarazadas con control prenatal
     * @param string $periodo
     *
     * @return json
     */
    protected function getDistribucionCp($id_odp, $provincia = null){        

        $odp = OdpTipo::find($id_odp);

        $cuatri_o_mes = $this->calcularCuatriOMes($odp->odp);       
        
        if($provincia){
            $resultados_detalle = MetaResultado::where('provincia',$provincia)
                                        ->where('year',date('Y'))
                                        ->where('id_tipo_meta',$id_odp)
                                        ->first()                                        
                                        ->detalle;
        }

        foreach ($resultados_detalle as $key => $value) {

            $desc = MetaDescripcion::where('meta_desc_id',$key)
                                    ->where('odp',$odp->odp)           
                                    ->first();            

            if($desc->mes){
                switch ($desc->meta_tipo) {
                    case 1:
                        if($desc->mes == $cuatri_o_mes){ 
                            $cantidad_para_cumplir = (int) $value;
                        }
                      break;
                    case 2:
                        if($desc->mes == $cuatri_o_mes - 1){
                            $cantidad_cumplida = (int) $value;
                        }
                      break;                                            
                }      
            }
            else{
                switch ($desc->meta_tipo) {                    
                    case 3:
                        $meta = $value;
                      break;
                    case 4:
                        $linea_base = $value;
                      break;                        
                }
            }
        }

        //var_dump(array('cantidad_cumplida' => $cantidad_cumplida, 'cantidad_para_cumplir' => $cantidad_para_cumplir, 'meta' => $meta, 'linea_base' => $linea_base));             

        if($cantidad_para_cumplir > $cantidad_cumplida){
            $data[] = array_merge(array('y' => 100 - $cantidad_para_cumplir), array('name' => 'resto', 'color' => '#EDEDED'));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir - $cantidad_cumplida),array('name' => 'faltante', 'color' => '#B00000 ', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_cumplida),array('name' => 'observado', 'color' => '#00FFFF'));
        }
        else{
            $data[] = array_merge(array('y' => 100 - $cantidad_cumplida), array('name' => 'resto', 'color' => '#EDEDED'));
            $data[] = array_merge(array('y' => $cantidad_cumplida - $cantidad_para_cumplir),array('name' => 'superado', 'color' => '#00CC00', 'sliced' => true, 'selected' => true));
            $data[] = array_merge(array('y' => $cantidad_para_cumplir),array('name' => 'observado', 'color' => '#00FFFF'));             
        }                

        $superObjeto = [
                        'titulo' => 'Meta: '. $cantidad_para_cumplir . '%',
                        'data' => json_encode($data) 
                        ];
     
        return $superObjeto;
    }

    /**
     * Calcula el mes o cuatrimestre (dependiendo el odp) y devuelve el código correspondiente.
     * @return [type]
     */
    protected function calcularCuatriOMes($odp_id){

        $dt = new \DateTime();        
        $dt->modify('-1 month');
        $mes_a_graficar = $dt->format('m');  

        if( MetaDescripcion::where('meta_tipo',1)
                            ->where('odp',$odp_id)
                            ->where('mes',$mes_a_graficar)
                            ->get() )
        {
            return $mes_a_graficar;
        }
        else{
            switch ($mes_a_graficar) {
                case 1:
                case 2:
                case 3:
                case 4:
                    return 300;
                    break;
                
                case 5:
                case 6:
                case 7:
                case 8:
                    return 100;
                    break;

                case 9:
                case 10:
                case 11:
                case 12:
                    return 200;
                    break;
            }
        }
    }

    /**
     * Calcula el mes o cuatrimestre (dependiendo el odp) y devuelve el código correspondiente.
     * @return [type]
     */
    protected function devolverFormatoDeMes($cuatri_o_mes){        
        switch ($cuatri_o_mes) {
            case 100:                
                return '1°C';
                break;
            case 200:                
                return '2°C';
                break;
            case 300:                
                return '3°C';
                break;
            
            case ($cuatri_o_mes < 13):                            
                $dt = \DateTime::createFromFormat('Ym' , date('Y') . $cuatri_o_mes);
                return strftime("%b %Y" , $dt->getTimeStamp());
                break;            
        }
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
     * Consulta de testeo: return '<pre>' . json_encode($resultados , JSON_PRETTY_PRINT) . '</pre>';
     * @return array
     */
    protected function getMapSeries($id_odp){        

        $resultados = MetaResultado::select('id_tipo_meta','detalle','provincia','geojson_provincia')
                                    ->join('geo.geojson as g' , 'odp.meta_resultado.provincia' , '=' , 'g.id_provincia')
                                    ->where('year' , date('Y'))
                                    ->where('id_tipo_meta',$id_odp)                                                                    
                                    ->orderBy('provincia' , 'desc')
                                    ->get();                                                

        foreach ($resultados as $fila){            

            $odp = OdpTipo::find($id_odp);

            $cuatri_o_mes = $this->calcularCuatriOMes($odp->odp);       
            
            if($fila['provincia']){
               
                foreach ($fila['detalle'] as $key => $value) {

                    $desc = MetaDescripcion::where('meta_desc_id',$key)
                                            ->where('odp',$odp->odp)
                                            ->first();

                    if($desc->mes){
                        switch ($desc->meta_tipo) {
                            case 1:
                                if($desc->mes == $cuatri_o_mes){ 
                                    $cantidad_para_cumplir = (int) $value;
                                }
                              break;
                            case 2:
                                if($desc->mes == $cuatri_o_mes - 1){
                                    $cantidad_cumplida = (int) $value;
                                }
                              break;                                            
                        }      
                    }
                    else{
                        switch ($desc->meta_tipo) {                    
                            case 3:
                                $meta = $value;
                              break;
                            case 4:
                                $linea_base = $value;
                              break;                        
                        }
                    }
                }
            }            
            
            $map['map-data'][] = array("value" => $cantidad_cumplida, "hc-key" => $fila['geojson_provincia'], "periodo" => date('Y').$cuatri_o_mes, "provincia" => $fila['provincia']);            
        }

        $map['map-data'] = json_encode($map['map-data']);
        $map['clase'] = $fila['provincia'];        

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
    public function getDetalleProvinciaODP($id_odp, $periodo, $provincia){                

        $odp = OdpTipo::find($id_odp);

        $cuatri_o_mes = $this->calcularCuatriOMes($odp->odp);       
        
        if($provincia){
            $resultados_detalle = MetaResultado::where('provincia',$provincia)
                                        ->where('year',date('Y'))
                                        ->where('id_tipo_meta',$id_odp)
                                        ->first()                                        
                                        ->detalle;
        }

        foreach ($resultados_detalle as $key => $value) {

            $desc = MetaDescripcion::where('meta_desc_id',$key)
                                    ->where('odp',$odp->odp)           
                                    ->first();            

            if($desc->mes){
                switch ($desc->meta_tipo) {
                    case 1:
                        if($desc->mes == $cuatri_o_mes){ 
                            $cantidad_para_cumplir = (int) $value;
                        }
                      break;
                    case 2:
                        if($desc->mes == $cuatri_o_mes - 1){
                            $cantidad_cumplida = (int) $value;
                        }
                      break;                                            
                }      
            }
            else{
                switch ($desc->meta_tipo) {                    
                    case 3:
                        $meta = $value;
                      break;
                    case 4:
                        $linea_base = $value;
                      break;                        
                }
            }
        }        

        $data['titulo'] = $odp->descripcion;
        $data['entidad'] = Provincia::find($provincia)->descripcion;
        $data['periodo'] = $this->devolverFormatoDeMes($cuatri_o_mes);
        $data['observado'] = number_format($cantidad_cumplida);
        $data['planificado'] = number_format($cantidad_para_cumplir);
        $data['meta'] = number_format($meta);
        $data['linea_base'] = number_format($meta);
        $data['odp'] = $odp->odp;                        

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
     * Devuelve la descripcion del indicador deseado
     *
     * @return array
     */
    protected function getDescripcionOdp($odp){        
        return view('componentes.descripcion-indicador', array('descripcion' => DescripcionODP::find($odp)));
    }

    /**
     * Devuelve la view de componentes alta (Chequear si es funcional esta funcion)
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
        $provincias = Provincia::all();
        $odp = OdpTipo::all();
        $data = [
            'page_title' => 'Carga de Datos ODP',                        
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
        
        $array_a_insertar['detalle'] = array();                
        
        foreach ($r->all() as $key => $value) {
            if($key == 'provincia'){
                $array_a_insertar[$key] = (string) $value;
            }
            elseif($key == 'indicador'){
                $array_a_insertar['id_tipo_meta'] = $value;   
            }
            else{
                $array_a_insertar['detalle'][$key] = $value;    
            }                        
        }        

        $array_a_insertar['year'] = intval(date('Y'));
        $array_a_insertar['detalle'] = json_encode($array_a_insertar['detalle']);
        
        $resultado = MetaResultado::updateOrCreate(['id_tipo_meta' => $array_a_insertar['id_tipo_meta'], 'provincia' => $array_a_insertar['provincia'], 'year' => $array_a_insertar['year']], ['detalle' => $array_a_insertar['detalle']]);

        if($resultado){
            return 'Se han ingresado los datos correctamente';
        } else {
          return 'Ha ocurrido un error';
        }
    }

    /**
     * Devuelvo la vista para el formulario de planificacion y de observado de la provincia
     *
     * @return null
     */
    public function getFormularioMetas($id_meta, $provincia, $tipo_meta){ 
        
        $id_odp = OdpTipo::find($id_meta);        

        if($tipo_meta == 'planificado'){
            $descripciones = MetaDescripcion::select('meta_desc_id','descripcion','meta_tipo','odp')->where('odp',$id_odp->odp)->whereIn('meta_tipo',[2,3,4])->groupBy(['meta_desc_id','descripcion','meta_tipo','odp'])->orderBy('meta_desc_id')->get();    
        }
        elseif($tipo_meta == 'observado'){
            $descripciones = MetaDescripcion::select('meta_desc_id','descripcion','meta_tipo','odp')->where('odp',$id_odp->odp)->where('meta_tipo',1)->groupBy(['meta_desc_id','descripcion','meta_tipo','odp'])->orderBy('meta_desc_id')->get();       
        }        

        if(isset(MetaResultado::where('id_tipo_meta',$id_meta)
                    ->where('year',intval(date('Y')))
                    ->where('provincia',$provincia)                    
                    ->first()->detalle)){           

            $detalle_resultados =  json_decode(MetaResultado::where('id_tipo_meta',$id_meta)
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
                foreach ($detalle_resultados as $campo => $resultado) {                  
                    if($campo == $descripcion->meta_desc_id){                
                        $superObjeto[$descripcion->meta_desc_id] = array("id" => $descripcion->meta_desc_id, "valor" => $resultado, "descripcion" => $descripcion->descripcion);                        
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
