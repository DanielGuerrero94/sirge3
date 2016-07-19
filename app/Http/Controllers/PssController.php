<?php

namespace App\Http\Controllers;

use Auth;
use Datatables;
use DB;
use Excel;
use ZipArchive;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Salud;
use App\Models\PSS\Grupo;
use App\Models\PSS\Diagnostico;
use App\Models\PSS\CEB;
use App\Models\PSS\LineaCuidado;
use App\Models\PSS\GrupoEtario as Etario;

use App\Models\Dw\FC\Fc002;
use App\Models\Dw\FC\Fc003;
use App\Models\Dw\FC\Fc004;
use App\Models\Dw\FC\Fc005;
use App\Models\Dw\FC\Fc006;


class PssController extends Controller
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
	 * Devuelve la vista principal del listado PSS
	 *
	 * @return null
	 */
	public function getListado(){
		$data = [
			'page_title' => 'Plan de Servicios de Salud'
		];
		return view('pss.pss' , $data);
	}

	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function getListadoTabla(){		
		$pss = Salud::select('codigo_prestacion','tipo','objeto','diagnostico','descripcion_grupal');		
		return Datatables::of($pss)
			->editColumn('descripcion_grupal' , '{!! str_limit($descripcion_grupal, 60) !!}')
			->addColumn('action' , function($ps){
				return '<button codigo="'. $ps->codigo_prestacion .'" class="ver btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
			})
			->make(true);
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
     * Devuelve listado de 12 meses 
     *
     * @return json
     */
    protected function getMesesArray(){

        $dt = new \DateTime();
        $dt->modify('-13 months');
        for ($i = 0 ; $i < 12 ; $i ++){
       		$dt->modify('+1 month');
            $meses[$i] = strftime("%b %Y" , $dt->getTimeStamp());
        }
        return json_encode($meses);
    }

    /**
     * Devuelve el rango de periodos a filtrar
     *
     * @return array
     */
    protected function getDateInterval(){

        $dt = new \DateTime();
        $dt->modify('-1 month');
        $interval['max'] = $dt->format('Ym');
        $dt->modify('-11 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

	/**
	 * Devuelve la serie para graficar la facturación
	 * @param string $id
	 *
	 * @return json
	 */
	protected function getProgreso($id){
		$interval = $this->getDateInterval();
		$data = [];

		$facturacion = Fc002::select('periodo' , DB::raw('sum(cantidad) as c') , DB::raw('sum(monto) as f'))
							->where('codigo_prestacion' , $id)
							->whereBetween('periodo',[$interval['min'],$interval['max']])
							->groupBy('periodo')
							->get();
		foreach ($facturacion as $key => $info){
			$data[0]['name'] = 'Cant. Fact.';
			$data[0]['data'][$key] = $info->c;
			$data[0]['color'] = '#ff851b';
			/*
			$data[1]['name'] = 'Monto. Fact.';
			$data[1]['data'][$key] = (int)($info->f/1000);
			*/
		}

		return json_encode($data);
	}

	/**
	 * Devuelve la serie para el gráfico de distribución
	 * @param string $id
	 *
	 * @return json
	 */
	protected function getDistribucion($id){
		$meses = $this->getMesesArray();
		$interval = $this->getDateInterval();
		$data = [];
		$i = 0;

		$regiones = Fc002::whereBetween('periodo',[$interval['min'],$interval['max']])
							->where('codigo_prestacion' , $id)
							->join('geo.provincias as p' , 'estadisticas.fc_002.id_provincia' , '=' , 'p.id_provincia')
                    		->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                    		->select('r.id_region' , 'r.nombre' , DB::raw('sum(cantidad) as c'))
                    		->groupBy('r.id_region')
                    		->groupBy('r.nombre')
                    		->get();

        foreach ($regiones as $key => $region){
            $data[$i]['color'] = $this->alter_brightness('#ff851b' , $key * 35);
            $data[$i]['id'] = (string)$region->id_region;
            $data[$i]['name'] = $region->nombre;
            $data[$i]['value'] = (int)$region->c;
            $i++;
        }

        for ($j = 0 ; $j <= 5 ; $j ++){
            $provincias = Fc002::whereBetween('periodo',[$interval['min'],$interval['max']])
                            ->where('r.id_region' , $j)
                            ->where('codigo_prestacion' , $id)
                            ->join('geo.provincias as p' , 'estadisticas.fc_002.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , DB::raw('sum(cantidad) as c'))
                            ->groupBy('r.id_region')
                            ->groupBy('p.id_provincia')
                            ->groupBy('p.nombre')
                            ->get();

            foreach ($provincias as $key => $provincia){
                $data[$i]['id'] = $provincia->id_region . "_" . $provincia->id_provincia;
                $data[$i]['name'] = $provincia->nombre;
                $data[$i]['parent'] = (string)$provincia->id_region;
                $data[$i]['value'] = (int)$provincia->c;
                $i++;
            }
        }


        for ($k = 1 ; $k <= 24 ; $k ++){

	    	$dt = \DateTime::createFromFormat('Ym' , $interval['max']);
	    	$dt->modify('+1 month');

        	for ($l = 0 ; $l < 12 ; $l ++){
	        	
	        	$dt->modify('-1 month');

	            $periodos = Fc002::where('periodo' , $dt->format('Ym'))
	            				->where('codigo_prestacion' , $id)
	            				->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
	            				->join('geo.provincias as p' , 'estadisticas.fc_002.id_provincia' , '=' , 'p.id_provincia')
                            	->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            	->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , 'periodo' , DB::raw('sum(cantidad) as c'))
                            	->groupBy('r.id_region')
                            	->groupBy('p.id_provincia')
                            	->groupBy('p.nombre')
                            	->groupBy('periodo')
                            	->get();
                
                foreach ($periodos as $key => $periodo){
                	$data[$i]['id'] = $periodo->id_region . "_" . $periodo->id_provincia . "_" . $periodo->periodo;
	                $data[$i]['name'] = strftime("%b %Y" , $dt->getTimeStamp());
	                $data[$i]['parent'] = (string)$periodo->id_region . "_" . $periodo->id_provincia;
	                $data[$i]['value'] = (int)$periodo->c;
	                $i++;
                }
        	}
        }

        return json_encode($data);

	}

	/**
	 * Devuelve el detalle de la prestación seleccionada
	 * @param string $id
	 *
	 * @return null
	 */
	public function getDetalle($id){

		$codigo = Salud::select('*' , 
			DB::raw("case when exists (select 1 from pss.codigos_anexo where codigo_prestacion = '$id') then 1 else 0 end as anexo"),
			DB::raw("case when exists (select 1 from pss.codigos_catastroficos where codigo_prestacion = '$id') then 1 else 0 end as catastrofico"),
			DB::raw("case when exists (select 1 from pss.codigos_ccc where codigo_prestacion = '$id') then 1 else 0 end as ccc"),
			DB::raw("case when exists (select 1 from pss.codigos_priorizadas where codigo_prestacion = '$id') then 1 else 0 end as priorizado"),
			DB::raw("case when exists (select 1 from pss.codigos_estrategicos where codigo_prestacion = '$id') then 1 else 0 end as estrategico"))
		->with(['grupo' => function($q){
			$q->with(['grupoEtario','lineaCuidado']);
		},'ceb' => function($q){
			$q->with('grupoEtario');
		},'odp' => function($q){
			$q->with('grupoEtario');
		}, 'trazadora' => function($q){
			$q->with('grupoEtario');
		}
		])->find($id);

		$array['ceb'] = array();

		foreach ($codigo->grupo as $prestacion){
			$array['grupos'][] = $prestacion->grupoEtario->descripcion;
			$array['lineas'][] = $prestacion->lineaCuidado->descripcion;
		}

		foreach ($codigo->ceb as $prestacion){
			$array['ceb'][] = $prestacion->grupoEtario->descripcion;
		}

		foreach ($codigo->odp as $prestacion){
			$array['odp'][$prestacion->id_odp][] = $prestacion->grupoEtario->descripcion;
		}

		foreach ($codigo->trazadora as $prestacion){
			$array['trazadora'][$prestacion->id_trazadora][] = $prestacion->grupoEtario->descripcion;
		}

		$array['grupos'] = array_unique($array['grupos']);
		$array['lineas'] = array_unique($array['lineas']);
		$array['ceb'] = array_unique($array['ceb']);
		
		if ($codigo->anexo){
			$array['atributos'][] = 'ANEXO';
		}

		if ($codigo->ccc){
			$array['atributos'][] = 'CARDIOPATÍAS CONGÉNITAS';
		}

		if ($codigo->catastrofico){
			$array['atributos'][] = 'CATASTRÓFICO';
		}

		if ($codigo->priorizado){
			$array['atributos'][] = 'PRIORIZADO';
		}

		if ($codigo->estrategico){
			$array['atributos'][] = 'ESTRATEGICO';
		}

		$data = [
			'page_title' => $id,
			'informacion' => $array,
			'codigo' => $codigo,
			'meses' => $this->getMesesArray(),
			'series' => $this->getProgreso($id),
			'distribucion' => $this->getDistribucion($id)
		];

		return view('pss.pss_detail' , $data);
	}

	/**
	 * Devuelve la vista para el listado de líneas de cuidado
	 *
	 * @return null
	 */
	public function getLineas(){
		$data = [
			'page_title' => 'Lineas de cuidado'
		];
		return view('pss.lineas_cuidado' , $data);
	}

	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function getLineasTabla(){
		$lineas = LineaCuidado::select('descripcion','id_linea_cuidado')->where('descripcion','!=','ANEXO');
		return Datatables::of($lineas)
			->addColumn('action' , function($linea){
				return '<button linea="'. $linea->id_linea_cuidado .'" class="ver btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
			})->make(true);
	}

	/**
	 * Devuelve la serie para el gráfico de lineas
	 *
	 * @return json
	 */
	protected function getSeriesLineaCuidado($id){
		$interval = $this->getDateInterval();

		$facturacion = Fc003::select('periodo' , DB::raw('sum(cantidad) as c') , DB::raw('sum(monto) as f'))
							->where('id_linea_cuidado' , $id)
							->whereBetween('periodo',[$interval['min'],$interval['max']])
							->groupBy('periodo')
							->get();

		foreach ($facturacion as $key => $info){
			$data[0]['name'] = 'Cant. Fact.';
			$data[0]['data'][$key] = $info->c;
			$data[0]['color'] = '#ff851b';
			/*
			$data[1]['name'] = 'Monto. Fact.';
			$data[1]['data'][$key] = (int)($info->f/1000);
			*/
		}

		if(isset($facturacion[0])){
			return json_encode($data);	
		}
		return json_encode("");	
		
	}

	/**
	 * Devuelve la serie para el gráfico de facturacion para un determinado grupo etario
	 * @param string $id
	 *
	 * @return json
	 */
	protected function getSeriesGrupoEtario($id){
		$interval = $this->getDateInterval();

		$facturacion = Fc006::select('periodo' , DB::raw('sum(cantidad) as c'))
							->where('id_grupo_etario' , $id)
							->whereBetween('periodo',[$interval['min'],$interval['max']])
							->groupBy('periodo')
							->orderBy('periodo','asc')
							->get();

	    $data = array();										    

		foreach ($facturacion as $key => $info){
			$data[0]['name'] = 'Cant. Fact.';
			$data[0]['data'][$key] = (int) $info->c;
			$data[0]['color'] = '#ff851b';			
		}

		return json_encode($data);
	}

	/**
	 * Devuelve la serie para el gráfico de distribución
	 * @param string $id
	 *
	 * @return json
	 */
	protected function getDistribucionLineaCuidado($id){
		$meses = $this->getMesesArray();
		$interval = $this->getDateInterval();
		$i = 0;

		$regiones = Fc003::whereBetween('periodo',[$interval['min'],$interval['max']])
							->where('id_linea_cuidado' , $id)
							->join('geo.provincias as p' , 'estadisticas.fc_003.id_provincia' , '=' , 'p.id_provincia')
                    		->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                    		->select('r.id_region' , 'r.nombre' , DB::raw('sum(cantidad) as c'))
                    		->groupBy('r.id_region')
                    		->groupBy('r.nombre')
                    		->get();

        foreach ($regiones as $key => $region){
            $data[$i]['color'] = $this->alter_brightness('#ff851b' , $key * 35);
            $data[$i]['id'] = (string)$region->id_region;
            $data[$i]['name'] = $region->nombre;
            $data[$i]['value'] = (int)$region->c;
            $i++;
        }

        for ($j = 0 ; $j <= 5 ; $j ++){
            $provincias = Fc003::whereBetween('periodo',[$interval['min'],$interval['max']])
                            ->where('r.id_region' , $j)
                            ->where('id_linea_cuidado' , $id)
                            ->join('geo.provincias as p' , 'estadisticas.fc_003.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , DB::raw('sum(cantidad) as c'))
                            ->groupBy('r.id_region')
                            ->groupBy('p.id_provincia')
                            ->groupBy('p.nombre')
                            ->get();

            foreach ($provincias as $key => $provincia){
                $data[$i]['id'] = $provincia->id_region . "_" . $provincia->id_provincia;
                $data[$i]['name'] = $provincia->nombre;
                $data[$i]['parent'] = (string)$provincia->id_region;
                $data[$i]['value'] = (int)$provincia->c;
                $i++;
            }
        }


        for ($k = 1 ; $k <= 24 ; $k ++){

	    	$dt = \DateTime::createFromFormat('Ym' , $interval['max']);
	    	$dt->modify('+1 month');

        	for ($l = 0 ; $l < 12 ; $l ++){
	        	
	        	$dt->modify('-1 month');

	            $periodos = Fc003::where('periodo' , $dt->format('Ym'))
	            				->where('id_linea_cuidado' , $id)
	            				->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
	            				->join('geo.provincias as p' , 'estadisticas.fc_003.id_provincia' , '=' , 'p.id_provincia')
                            	->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            	->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , 'periodo' , DB::raw('sum(cantidad) as c'))
                            	->groupBy('r.id_region')
                            	->groupBy('p.id_provincia')
                            	->groupBy('p.nombre')
                            	->groupBy('periodo')
                            	->get();
                
                foreach ($periodos as $key => $periodo){
                	$data[$i]['id'] = $periodo->id_region . "_" . $periodo->id_provincia . "_" . $periodo->periodo;
	                $data[$i]['name'] = strftime("%b %Y" , $dt->getTimeStamp());
	                $data[$i]['parent'] = (string)$periodo->id_region . "_" . $periodo->id_provincia;
	                $data[$i]['value'] = (int)$periodo->c;
	                $i++;
                }
        	}
        }

        if(isset($regiones[0])){
			return json_encode($data);	
		}
		return json_encode("");	

	}

	/**
	 * Devuelve la serie para el gráfico de distribución
	 * @param string $id
	 *
	 * @return json
	 */
	protected function getDistribucionGrupoEtario($id){
		$meses = $this->getMesesArray();
		$interval = $this->getDateInterval();
		$i = 0;

		$data = [];

		$regiones = Fc006::select('r.id_region' , 'r.nombre' , DB::raw('sum(cantidad) as c'))							
							->join('geo.provincias as p' , 'estadisticas.fc_006.id_provincia' , '=' , 'p.id_provincia')
                    		->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                    		->whereBetween('periodo',[$interval['min'],$interval['max']])
							->where('id_grupo_etario' , $id)                    		
                    		->groupBy('r.id_region','r.nombre')                    		
                    		->get();

        foreach ($regiones as $key => $region){
            $data[$i]['color'] = $this->alter_brightness('#ff851b' , $key * 35);
            $data[$i]['id'] = (string)$region->id_region;
            $data[$i]['name'] = $region->nombre;
            $data[$i]['value'] = (int)$region->c;
            $i++;
        }

        for ($j = 0 ; $j <= 5 ; $j ++){
            $provincias = Fc006::select('r.id_region' , 'p.id_provincia' , 'p.nombre' , DB::raw('sum(cantidad) as c'))            				
                            ->join('geo.provincias as p' , 'estadisticas.fc_006.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->whereBetween('periodo',[$interval['min'],$interval['max']])
                            ->where('r.id_region' , $j)
                            ->where('id_grupo_etario' , $id)                            
                            ->groupBy('r.id_region','p.id_provincia','p.nombre')                            
                            ->get();

            foreach ($provincias as $key => $provincia){
                $data[$i]['id'] = $provincia->id_region . "_" . $provincia->id_provincia;
                $data[$i]['name'] = $provincia->nombre;
                $data[$i]['parent'] = (string)$provincia->id_region;
                $data[$i]['value'] = (int)$provincia->c;
                $i++;
            }
        }


        /*for ($k = 1 ; $k <= 24 ; $k ++){

	    	$dt = \DateTime::createFromFormat('Ym' , $interval['max']);
	    	$dt->modify('+1 month');

        	for ($l = 0 ; $l < 12 ; $l ++){
	        	
	        	$dt->modify('-1 month');

	            $periodos = Fc006::where('periodo' , $dt->format('Ym'))
	            				->where('id_grupo_etario' , $id)
	            				->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
	            				->join('geo.provincias as p' , 'estadisticas.fc_006.id_provincia' , '=' , 'p.id_provincia')
                            	->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            	->select('r.id_region' , 'p.id_provincia' , 'p.nombre' , 'periodo' , DB::raw('sum(cantidad) as c'))
                            	->groupBy('r.id_region')
                            	->groupBy('p.id_provincia')
                            	->groupBy('p.nombre')
                            	->groupBy('periodo')
                            	->get();
                
                foreach ($periodos as $key => $periodo){
                	$data[$i]['id'] = $periodo->id_region . "_" . $periodo->id_provincia . "_" . $periodo->periodo;
	                $data[$i]['name'] = strftime("%b %Y" , $dt->getTimeStamp());
	                $data[$i]['parent'] = (string)$periodo->id_region . "_" . $periodo->id_provincia;
	                $data[$i]['value'] = (int)$periodo->c;
	                $i++;
                }
        	}
        }*/

        return json_encode($data);

	}

	/**
	 * Devuelve la vista del detalle de la línea de cuidado
	 * @param int $id
	 *
	 * @return null
	 */
	public function getDetalleLinea($id){
		$linea = LineaCuidado::find($id);		

		$data = [
			'page_title' => $linea->descripcion,
			'linea' => $linea,
			'meses' => $this->getMesesArray(),
			'series' => $this->getSeriesLineaCuidado($id),
			'tree_map' => $this->getDistribucionLineaCuidado($id),
			'back' => 'pss-lineas'
		];

		return view('pss.lineas_cuidado_detail' , $data);
	}

	/**
	 * Devuelve JSON para la datatable
	 * @param int $id
	 *
	 * @return json
	 */
	public function getLineasCodigosTabla($id){
		$codigos = Grupo::select('codigo_prestacion','id_grupo_etario')->with(['grupoEtario'])->where('id_linea_cuidado' , $id);
		return Datatables::of($codigos)->make(true);
	}

		/**
	 * Devuelve JSON para la datatable
	 * @param int $id
	 *
	 * @return json
	 */
	public function getGruposCodigosTabla($id){

		$codigos = Salud::select('pss.codigos.codigo_prestacion','descripcion_grupal')					
				   ->join('pss.codigos_grupos', function($join) use ($id)
                                {
                                    $join->on('pss.codigos_grupos.codigo_prestacion','=','pss.codigos.codigo_prestacion')
                                         ->where('pss.codigos_grupos.id_grupo_etario','=',$id);
                                })
				   ->groupBy('pss.codigos.codigo_prestacion');									
		return Datatables::of($codigos)->make(true);
	}

	/**
	 * Devuelve la serie para graficar
	 *
	 * @return json
	 */
	protected function getSeriesSexoEdad(){

		$sexos = Fc004::select('sexo' , 'edad' , DB::raw('sum(cantidad) as c'))
						->whereIn('sexo' , ['M','F'])
						->whereBetween('edad' , [0,64])
						->groupBy('sexo')
						->groupBy('edad')
						->orderBy('edad')
						->orderBy('sexo')
						->get();
		
		foreach ($sexos as $sexo){
				
			$char[0]['name'] = 'Hombres';
			$char[1]['name'] = 'Mujeres';

			if ($sexo->sexo == 'M'){
				$char[0]['data'][] = (int)(-$sexo->c/1000);
				$char[0]['color'] = '#3c8dbc';
			} else {
				$char[1]['data'][] = (int)($sexo->c/1000);
				$char[1]['color'] = '#D81B60';
			}
		}
		
		return json_encode($char);

	}

	/**
	 * Devuelve la vista para los grupos etarios
	 *
	 * @return null
	 */
	public function getGrupos(){

		$grupos = [
			'"0-1"','"2-3"','"4-5"','"6-7"','"8-9"',
			'"10-11"','"12-13"','"14-15"','"16-17"','"18-19"',
			'"20-21"','"22-23"','"24-25"','"26-27"','"28-29"',
			'"30-31"','"32-33"','"34-35"','"36-37"','"38-39"',
			'"40-41"','"42-43"','"44-45"','"46-47"','"48-49"',
			'"50-51"','"52-53"','"54-55"','"56-57"','"58-59"',
			'"60-61"','"62-63"','"64-65"'
		];

		$data = [
			'page_title' => 'Grupos Etarios',
			'series' => $this->getSeriesSexoEdad(),
			'edades' => implode(',',range(0,64))
		];
		return view('pss.grupos' , $data);
	}


	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function getGruposTabla(){
		$grupos = Etario::all();
		return Datatables::of($grupos)
			->addColumn('action' , function($grupo){
				return '<button grupo="'. $grupo->id_grupo_etario .'" class="ver btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Ver</button>';
			})
			->make(true);
	}

	/** 
	 * Devuelve el detalle de un grupo determinado
	 * @param int $id
	 * 
	 * @return null
	 */
	public function getDetalleGrupos($id){
		
		$grupoEtario = Etario::find($id);

		/*$codigo_grupo = Grupo::select('codigo_prestacion','descripcion')
		->where('id_grupo_etario','=',$id)
		->groupBy('codigo_prestacion','descripcion')
		->orderBy('codigo_prestacion','desc')		
		->orderBy('descripcion','desc')
		->get();*/

		$data = [
			'page_title' => $grupoEtario->descripcion,
			'id_grupo_etario' => $grupoEtario->id_grupo_etario,			
			'meses' => $this->getMesesArray(),
			'series' => $this->getSeriesGrupoEtario($id),
			'tree_map' => $this->getDistribucionGrupoEtario($id),
			'back' => 'pss-grupos'
		];

		return view('pss.grupos_detail' , $data);
	}

	/**
     * Descarga la tabla de códigos
     *
     * @return null
     */
    public function generarTabla(){

      $codigos = Salud::join('pss.diagnosticos' , 'pss.diagnosticos.diagnostico' , '=' , 'pss.codigos.diagnostico')
      				   ->select('codigo_prestacion','tipo','objeto','pss.codigos.diagnostico','descripcion_grupal','descripcion as descripcion_diagnostico')
      				   ->orderBy('pss.codigos.codigo_prestacion' , 'asc')       				   
       				   ->get();        
      
      $data = ['codigos' => $codigos];

      if(file_exists('../storage/exports/Pss_CODIGOS.xls')){
        unlink('../storage/exports/Pss_CODIGOS.xls');  
      }

      Excel::create('Pss_CODIGOS' , function ($e) use ($data){
        $e->sheet('Tabla_SUMAR' , function ($s) use ($data){
          $s->setHeight(1, 20);
          $s->setColumnFormat([
              'B' => '0'
            ]);
          $s->loadView('pss.tabla' , $data);
        });
      })
      ->store('xls');

      $zip = new ZipArchive();
      $zip->open('../storage/exports/PSS_CODIGOS.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);      
      $zip->addFile('../storage/exports/Pss_CODIGOS.xls', 'Pss_CODIGOS.xls');      
      $zip->close();
    }

    /**
     * Decargar la tabla generada
     *
     * @return null
     */
    public function descargarTabla(){
      return response()->download('../storage/exports/PSS_CODIGOS.zip');
    }
}
