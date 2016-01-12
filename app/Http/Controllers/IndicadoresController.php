<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;
use App\Models\Indicador;
use App\Models\Indicadores\MedicaRangos;
use App\Models\Indicadores\Descripcion;

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
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
	protected function getDateInterval($periodo){

        $dt = \DateTime::createFromFormat('Ym' , $periodo);
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-12 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

    protected function getPeriodosIndicador($id,$indicador,$periodo)
	{         

		$intervalo = $this->getDateInterval($periodo);						

        $dt = \DateTime::createFromFormat('Ym',$periodo);
		for ($i=0; $i < 12; $i++) { 
			$periodos[] = $dt->format('Ym');
			$dt->modify('-1 month');
		}

        return $periodos;            
	}	

	/**
	 * Devuelve la vista de los indicadores
	 * @param string $id
	 *
	 * @return null
	 */
	public function getIndicadoresMedica($id , $periodo, $back){		
		

		$indicador = Indicador::select('id_provincia','periodo','codigo_indicador','resultado','id')
                ->with([                
                'rangoIndicador' => function($q){ 
                    $q->with(['descripcionIndicador']); 
                	}
                ])
        ->where('id_provincia','=',$id)
        ->where('periodo','=',(integer) str_replace('-','',$periodo))
        ->get();

        $indicadorAnterior = $indicador[0]['rangoIndicador']['codigo_indicador'];                
        $indicadorReal[0] = $indicador[0];
        $grafico[0]['indicador'] = $indicador[0];            
        $indicadorReal[0]['resultadoA'] = $indicador[0]['resultado'];        

        for ($i=1; $i < count($indicador); $i++) { 
        	if ( $indicador[$i]['rangoIndicador']['codigo_indicador'] != $indicadorAnterior ) {        		
        		$indicadorAnterior = $indicador[$i]['rangoIndicador']['codigo_indicador'];        
        		$indicadorReal[$i] = $indicador[$i];        		        	
        		$grafico[$i]['indicador'] = $indicador[$i];            
        		$indicadorReal[$i]['resultadoA'] = $indicador[$i]['resultado'];        		
        		$indicadorReal[$i]['resultadoTotal'] = $this->getResultadoIndicadorReal($id , $indicadorAnterior, $periodo);
        		return json_encode($indicadorReal);
        	}
        	else{
        		$indicadorReal[$i-1]['resultadoB'] = $indicador[$i]['resultado'];
        	}        	        	     
        }
        
        $provincia = Provincia::find($id);           

		$data = [
			'page_title' => 'Indicadores médica: '. $provincia->descripcion . ' periodo: ' . $periodo,
			'indicador' => $indicadorReal,
			'back' => $back,
			'provincia' => $provincia,
			'periodo' => $periodo
		];
		//return json_encode($data);            
		return view('indicadores.medica' , $data);

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

		$intervalo = $this->getDateInterval($periodoActual);		

        $rows = Indicador::select('id_provincia','periodo','codigo_indicador','resultado')                
        ->where('id_provincia','=',$id)
        ->whereBetween('periodo',array($intervalo['min'],$intervalo['max']))        
        ->get();

        $indicadorAnterior = $rows[0]['codigo_indicador'];

        return json_encode($grafico);            
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
        $rows = Indicador::select('id_provincia','periodo','codigo_indicador','resultado')                
        ->where('id_provincia','=',$id)
        ->where('periodo','=',$periodo)
        ->where('codigo_indicador','LIKE', $indicador . '%')
        ->get();                     

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

		$dt = \DateTime::createFromFormat('Y-m' , $periodo);
        $period = $dt->format('Ym');					        
        $periodos = $this->getPeriodosIndicador($id,$indicador,$period);

        for ($i=0; $i < count($periodos) ; $i++) { 
        	$resultados[] = $this->getResultadoIndicadorDelMes($id,$indicador,$periodos[$i]);        	
        }
                
        return json_encode($resultados);
        //return (array_sum($resultados) / count($resultados));              
	}
}
