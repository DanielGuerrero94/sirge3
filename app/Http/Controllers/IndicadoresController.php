<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;
use App\Models\Indicador;
use App\Models\Indicadores\MedicaRangos;
use App\Models\Indicadores\Descripcion;
use DB;

use Carbon\Carbon;

class IndicadoresController extends Controller
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
	 * Devuelve la vista principal
	 *
	 * @return null
	 */
	public function getIndicadoresMedicaForm(){

		$provincias = Provincia::all();

		$data = [
			'page_title' => 'Indicadores médica',
			'provincias' => $provincias
		];
		return view('indicadores.provincia' , $data);
	}

	/**
	 * Devuelve la vista principal de indicadores priorizados
	 *
	 * @return view
	 */
	public function getIndicadoresEfectoresForm(){

		$provincias = Provincia::all();
		$indicadores = Descripcion::whereNotIn('indicador',['3.10','3.11','3.12','3.13','3.6','3.9'])
		->orderBy('indicador','asc')
		->get();

		$anio = date('Y');
		$dt = \DateTime::createFromFormat('Y',$anio);
        $anios[] = $dt->format('Y');
        $dt->modify('-1 year');
        $anios[] = $dt->format('Y');
		
		$data = [
			'page_title' => 'Indicadores Priorizados',
			'provincias' => $provincias,
			'indicadores' => $indicadores,
			'anios' => $anios
		];

		return view('indicadores.priorizados' , $data);
	}

	/**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
	protected function getDateInterval12Months($periodo){

        $dt = \DateTime::createFromFormat('Ym' , $periodo);
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-12 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

    protected function getDateInterval6Months($periodo){

        $dt = \DateTime::createFromFormat('Ym' , $periodo);
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-6 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

    protected function getColorSegunMeta($resultado, $datosIndicador){

        if($resultado < $datosIndicador['min_verde'] && $resultado > $datosIndicador['max_verde'])
        {
	        return 'lime';
        }
        elseif($resultado < $datosIndicador['min_rojo']){
        	return 'red';
        }
        else{
        	return 'yellow';
        }
    }

    protected function getPeriodosIndicador($id,$indicador,$periodo)
	{         

		$intervalo = $this->getDateInterval12Months((integer) str_replace('-','',$periodo));

		$periodos = Indicador::select(DB::raw('distinct(periodo) as periodo'))
		->where('id_provincia','=',$id)
        ->whereBetween('periodo',array($intervalo['min'],$intervalo['max']))        
		->where( DB::raw('left(codigo_indicador,-2)'),'=',$indicador)
        ->orderBy( DB::raw('1'),'desc')        
        ->get();

		$arrayPeriodos = array();

		foreach ($periodos as $unPeriodo) {
			array_push($arrayPeriodos, $unPeriodo['periodo']);
		}

        return $arrayPeriodos;            
	}	

	/**
	 * Devuelve la vista de los indicadores
	 * @param string $id
	 *
	 * @return null
	 */
	public function getIndicadoresMedica($id , $periodo, $back){		
		

		$indicador = Indicador::select('periodo', DB::raw('left(codigo_indicador,-2) as codigo_indicador'), 'id_rango_indicador')
                ->with([                
                'rangoIndicador' => function($q){ 
                    $q->with(['descripcionIndicador']); 
                	}
                ])
        ->where('id_provincia','=',$id)
        ->where('periodo','=',(integer) str_replace('-','',$periodo))
        ->groupBy(DB::raw('left(codigo_indicador,-2)'),'periodo','id_rango_indicador')
        ->orderBy(DB::raw('left(codigo_indicador,-2)'),'asc')
        ->orderBy('periodo','desc')
        ->get();

        $dt = \DateTime::createFromFormat('Y-m' , $periodo);
	    $periodo_sin_guion = $dt->format('Ym');		
        
        for ($i=0; $i < count($indicador); $i++) {         	       	    		      
    		$indicadorReal[$i] = $indicador[$i];        		        	        		        		
    		$indicadorReal[$i]['resultadoTotal'] = $this->getResultadoIndicadorReal($id , $indicador[$i]['codigo_indicador'], $periodo_sin_guion);        		        	
    		$indicadorReal[$i]['color'] = $this->getColorSegunMeta($indicadorReal[$i]['resultadoTotal'], $indicador[$i]['rangoIndicador']);    		
        }                
        
        $provincia = Provincia::find($id);           

        $grafico = $this->getGraficoEvolucion($id , $periodo);     

		$data = [
			'page_title' => 'Indicadores médica: '. $provincia->descripcion . ' periodo: ' . $periodo,
			'indicadores' => $indicadorReal,
			'back' => $back,
			'provincia' => $provincia,
			'periodo' => $periodo,
			'grafico' => $grafico			
		];

		return view('indicadores.medica' , $data);

	}

	/**
	 * Devuelve los datos para los highcharts de evolucion
	 * @param string $id
	 * @param string $periodo
	 *
	 * @return array
	 */
	public function getGraficoEvolucion($id , $periodo){		
		

		$indicador = Indicador::select('periodo', DB::raw('left(codigo_indicador,-2) as codigo_indicador'),'id_rango_indicador')
		->with([                
                'rangoIndicador' => function($q){ 
                    $q->with(['descripcionIndicador']); 
            	}])                
        ->where('id_provincia','=',$id)
        ->where('periodo','=',(integer) str_replace('-','',$periodo))
        ->groupBy(DB::raw('left(codigo_indicador,-2)'),'periodo','id_rango_indicador')
        ->orderBy(DB::raw('left(codigo_indicador,-2)'),'asc')
        ->orderBy('periodo','desc')
        ->get();        

        for ($i=0; $i < count($indicador); $i++) {
        	$grafico[$i]['indicador'] = $indicador[$i]['codigo_indicador'];
        	$grafico[$i]['rangos'] = $indicador[$i]['rangoIndicador'];
    		$grafico[$i]['resultados'] = $this->getGraficoIndicadores($id , $indicador[$i]['codigo_indicador'], $indicador[$i]['periodo']);    		    		
    		$grafico[$i]['categories'] = array();                       
        	$grafico[$i]['data'] = array();    		    		
    		foreach ($grafico[$i]['resultados'] as $unPeriodoConResultado) { 
    			$dt = \DateTime::createFromFormat('Ym' , $unPeriodoConResultado['periodo']);				    			    			
    			$period = date ('m/y', strtotime($dt->format('Y-m')));		    			
    			array_unshift($grafico[$i]['categories'], $period);    			
    			//array_unshift($grafico[$i]['data'], (float) number_format((float)$unPeriodoConResultado['resultado'], 2, '.', '.'));
    			array_unshift($grafico[$i]['data'], (float) number_format((float)$this->getResultadoIndicadorReal($id,$grafico[$i]['indicador'],$unPeriodoConResultado['periodo']), 2, '.', '.'));    		    			  			    		    			  			
    		}    		
        }        
                               
		return $grafico;
	}

	/**
	 * Devuelve el resultado del indicador
	 *
	 * @param  string  $id_provincia
	 * @param  string  $indicador
	 * @param  integer  $periodoActual
     * @return integer
	 */
	public function getGraficoIndicadores($id,$indicador,$periodoActual)
	{                 				

		$intervalo = $this->getDateInterval6Months($periodoActual);		

        $rows = Indicador::select('periodo', DB::raw('left(codigo_indicador,-2) as codigo_indicador'))                
        ->where('id_provincia','=',$id)
        ->where( DB::raw('left(codigo_indicador,-2)'),'=',$indicador)
        ->whereBetween('periodo',array($intervalo['min'],$intervalo['max']))
        ->groupBy('periodo', DB::raw('left(codigo_indicador,-2)'))
        ->orderBy('periodo','desc')
        ->orderBy(DB::raw('left(codigo_indicador,-2)'),'asc')
        ->get();        
        
        for ($i=0; $i < count($rows); $i++) { 
        	$grafico[$i]['periodo'] = $rows[$i]['periodo'];
        	$grafico[$i]['resultado'] = $this->getResultadoIndicadorDelMes($id,$rows[$i]['codigo_indicador'],$rows[$i]['periodo']);        	
        }

        return $grafico;            
	}

	/**
	 * Devuelve el resultado del indicador del mes
	 *
	 * @param  string  $id_provincia
	 * @param  string  $indicador
	 * @param  integer  $periodoActual
     * @return integer
	 */
	public function getResultadoIndicadorDelMes($id,$indicador,$periodo)
	{                 						               	
       	$rows = Indicador::select('codigo_indicador','resultado')                
        ->where('id_provincia','=',$id)
        ->where('periodo','=',$periodo)
        ->where('codigo_indicador','LIKE', $indicador . '%')
        ->orderBy('codigo_indicador','asc')                                  
        ->get();
                
		if($rows[1]['resultado'] == 0){
			$rows[0] = 0;
		}                

    	$resultado = ($rows[0]['resultado'] / (($rows[1]['resultado'] == 0) ? 1 : $rows[1]['resultado'])) * 100;	    		
        return $resultado;            
	}

	/**
	 * Devuelve el resultado del indicador real (comparando con los 12 meses anteriores)
	 *
	 * @param  string  $id_provincia
	 * @param  string  $indicador
	 * @param  integer  $periodo
     * @return integer
	 */
	public function getResultadoIndicadorReal($id,$indicador,$periodo)
	{         
		        									      
    	$periodos = $this->getPeriodosIndicador($id,$indicador,$periodo);    	
	        
	        if($indicador == '3.11' || $indicador == '3.12' || $indicador == '3.13'){
	        	for ($i=0; $i < count($periodos) ; $i++) {
	        		$resultados[] = $this->getResultadoIndicadorDelMes($id,$indicador,$periodos[$i]);
	        	}
	        }
	        else
	        {
	         	$resultados[] = $this->getResultadoIndicadorDelMes($id,$indicador,$periodo);
	        } 	              
	        	        
	        return (array_sum($resultados) / count($resultados));
	}

	public function getListadoPriorizadosView($id,$indicador,$year,$back)
	{				
		$data = [
			'page_title' => 'Indicadores Priorizados de ' . $id, 						
			'back' => $back,
			'id_provincia' => $id,
			'indicador' => $indicador,
			'periodo' => $year.'01'	,
			'anio' => $year				
		];

		return view('indicadores.listado' , $data);
	}	

	public function getListadoPriorizadosTabla($id,$indicador,$year)
	{		
		if ($indicador == "5.3") 
		{
			$resultados = $this->getResultadosEfectoresPriorizadosNoPorcentual($indicador,$id,$year.'01');
		} 
		else 
		{
			$resultados = $this->getResultadosEfectoresPriorizadosPorcentual($indicador,$id,$year.'01');
		}				

		for ($i=0; $i < count($resultados); $i++) { 			
			$datatables[$i]['nombre']	= $resultados[$i]->nombre;	
			$datatables[$i]['efector']	= $resultados[$i]->efector;											
			$datatables[$i]['c1_color'] = $this->getColorCuatrimestre($resultados[$i]->c1,$resultados[$i]->meta_c1,$year,1);
			$datatables[$i]['c2_color'] = $this->getColorCuatrimestre($resultados[$i]->c2,$resultados[$i]->meta_c2,$year,2);
			$datatables[$i]['c3_color'] = $this->getColorCuatrimestre($resultados[$i]->c3,$resultados[$i]->meta_c3,$year,3);
			$datatables[$i]['c1'] = '<a href="#" efector="'.$resultados[$i]->efector.'" color="'.$datatables[$i]['c1_color'].'" cuatri="1" class="detalle badge bg-'.$datatables[$i]['c1_color'].'">'. $resultados[$i]->c1 .'</a>';
			$datatables[$i]['c2'] = '<a href="#" efector="'.$resultados[$i]->efector.'" color="'.$datatables[$i]['c2_color'].'" cuatri="2" class="detalle badge bg-'.$datatables[$i]['c2_color'].'">'. $resultados[$i]->c2 .'</a>';	
			$datatables[$i]['c3'] = '<a href="#" efector="'.$resultados[$i]->efector.'" color="'.$datatables[$i]['c3_color'].'" cuatri="3" class="detalle badge bg-'.$datatables[$i]['c3_color'].'">'. $resultados[$i]->c3 .'</a>';		
		}

		return json_encode($datatables);

		//return Datatables::make($aobjeto)
        //->make(true);
        //->addColumn('action' , function($benef){
        //    return '<button clave-beneficiario="'.$benef->clave_beneficiario.'" class="ver-beneficiario btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
        //})
        
	}

	public function getQuarterByMonth($monthNumber) {
 		return floor(($monthNumber - 1) / 3) + 1;
	}

	protected function getColorCuatrimestre($valor,$meta,$año,$cuatri){
		$anio = date('Y');
		$curMonth = date("m", time());		

		if (intval($anio) == $año && $cuatri <= $this->getQuarterByMonth(intval($curMonth))) {
			if($valor < $meta){
				return 'red';
			}
			else{
				return 'green';
			}		
		}
		elseif (intval($anio) == $año && $cuatri > $this->getQuarterByMonth(intval($curMonth))) {			
			return 'grey';			
		}
		elseif (intval($anio) > $año) {
			if($valor < $meta){
				return 'red';
			}
			else{
				return 'green';
			}			
		}
		else{
			return 'red';
		}				
	}

	protected function getResultadosEfectoresPriorizadosNoPorcentual($indicador, $id_provincia, $periodo) {
				
		return DB::select( 'SELECT nombre, r.efector, case
			when abril > 0 then abril
			else (case
				when marzo > 0 then marzo
				else (case
					when febrero > 0 then febrero
					else (case
						when enero > 0 then enero
						else 0 end) end) end) end as c1, case
										when agosto > 0 then agosto
										else (case
											when julio > 0 then julio
											else (case
												when junio > 0 then junio
												else (case
													when mayo > 0 then mayo
													else 0 end) end) end) end as c2, case
																	when diciembre > 0 then diciembre
																	else (case
																		when noviembre > 0 then noviembre
																		else (case
																			when octubre > 0 then octubre
																			else (case
																				when septiembre > 0 then septiembre
																				else 0 end) end) end) end as c3, i.c1 as meta_c1, i.c2 as meta_c2, i.c3 as meta_c3

	FROM indicadores.resumen_anio_indicadores_priorizados_no_porcentual(?::integer,?::character varying,?::character varying) r
	LEFT JOIN indicadores.metas_efectores_priorizados i ON r.efector = i.efector
	WHERE 
		i.indicador = ?
		ORDER BY 3 desc;', [$periodo,$id_provincia,$indicador,$indicador]);		
	}

	protected function getResultadosEfectoresPriorizadosPorcentual($indicador, $id_provincia, $periodo) 
	{	
		return DB::select( 'SELECT nombre, r.efector, case
			when abril > 0 then abril
			else (case
				when marzo > 0 then marzo
				else (case
					when febrero > 0 then febrero
					else (case
						when enero > 0 then enero
						else 0 end) end) end) end as c1, case
										when agosto > 0 then agosto
										else (case
											when julio > 0 then julio
											else (case
												when junio > 0 then junio
												else (case
													when mayo > 0 then mayo
													else 0 end) end) end) end as c2, case
																	when diciembre > 0 then diciembre
																	else (case
																		when noviembre > 0 then noviembre
																		else (case
																			when octubre > 0 then octubre
																			else (case
																				when septiembre > 0 then septiembre
																				else 0 end) end) end) end as c3, i.c1 as meta_c1, i.c2 as meta_c2, i.c3 as meta_c3

	FROM indicadores.resumen_anio_indicadores_priorizados(?,?,?) r
	LEFT JOIN indicadores.metas_efectores_priorizados i ON r.efector = i.efector
	WHERE 
		i.indicador = ?
		ORDER BY c1 desc;', [$periodo,$id_provincia,$indicador,$indicador]);		
	}
}
