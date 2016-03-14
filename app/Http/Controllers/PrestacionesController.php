<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Database\QueryException;
use Validator;
use Auth;
use DB;
use Datatables;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Subida;
use App\Models\Lote;
use App\Models\Rechazo;
use App\Models\Prestacion;

use App\Models\Dw\FC\Fc001;
use App\Models\Dw\FC\Fc005;

use App\Models\Geo\Provincia;

class PrestacionesController extends Controller
{
	private 
		$_rules = [
			'operacion' => 'required|in:A,M',
			'estado' => 'required|in:L,D',
			'numero_comprobante' => 'required|max:50',
			'codigo_prestacion' => 'required|exists:pss.codigos,codigo_prestacion',
			'subcodigo_prestacion' => 'max:3',
			'precio_unitario' => 'required|numeric',
			'fecha_prestacion' => 'required|date_format:Y-m-d',
			'clave_beneficiario' => 'required|exists:beneficiarios.beneficiarios,clave_beneficiario',
			'tipo_documento' => 'exists:sistema.tipo_documento,tipo_documento',
			'clase_documento' => 'in:P,A,C',
			'numero_documento' => 'max:8',
			'orden' => 'required|numeric',
			'efector' => 'required|exists:efectores.efectores,cuie'
		],
		$_data = [
			'operacion',
			'estado',
			'numero_comprobante',
			'codigo_prestacion',
			'subcodigo_prestacion',
			'precio_unitario',
			'fecha_prestacion',
			'clave_beneficiario',
			'tipo_documento',
			'clase_documento',
			'numero_documento',
			'orden',
			'efector',
			'lote',
			'datos_reportables'
		],
		$_resumen = [
			'insertados' => 0,
			'rechazados' => 0,
			'modificados' => 0
		],
		$_error = [
			'lote' => '',
			'registro' => '',
			'motivos' => ''
		];

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
	 * Crea un nuevo lote
	 * @param int $id_subida
	 *
	 * @return int
	 */
	protected function nuevoLote($id_subida){
		$l = new Lote;
		$l->id_subida = $id_subida;
		$l->id_usuario = Auth::user()->id_usuario;
		$l->id_provincia = Auth::user()->id_provincia;
		$l->registros_in = 0;
		$l->registros_out = 0;
		$l->registros_mod = 0;
		$l->id_estado = 1;
		$l->save();
		return $l->lote;
	}

	/**
	 * Actualiza el lote con los datos procesados
	 * @param int $lote
	 * @param array $resumen
	 *
	 * @return bool
	 */
	protected function actualizaLote($lote , $resumen) {
		$l = Lote::findOrFail($lote);
		$l->registros_in = $resumen['insertados'];
		$l->registros_out = $resumen['rechazados'];
		$l->registros_mod = $resumen['modificados'];
		$l->fin = 'now';
		return $l->save();
	}

	/**
	 * Actualiza el archivo con los datos procesados
	 * @param int $id
	 *
	 * @return bool
	 */
	protected function actualizaSubida($subida) {
		$s = Subida::findOrFail($subida);
		$s->id_estado = 2;
		return $s->save();
	}

	/**
	 * Arma el array de prestacion
	 * @param array $linea
	 *
	 * @return array
	 */
	protected function armarArray($linea , $lote) {

		$datos_reportables = array();

		if($linea[11] != null && $linea[12] != null && $linea[11] != '' && $linea[12] != ''){							
			$datos_reportables[$linea[11]] = $linea[12];							
		}
		if($linea[13] != null && $linea[14] != null && $linea[13] != '' && $linea[14] != ''){							
			$datos_reportables[$linea[13]] = $linea[14];
		}
		if($linea[15] != null && $linea[16] != null && $linea[15] != '' && $linea[16] != ''){							
			$datos_reportables[$linea[15]] = $linea[16];
		}
		if($linea[17] != null && $linea[18] != null && $linea[17] != '' && $linea[18] != ''){							
			$datos_reportables[$linea[17]] = $linea[18];
		}						

		$json_datos_reportables = json_encode($datos_reportables);

		if(count($datos_reportables) < 1){
			$json_datos_reportables = null;
		}

		$prestacion = [
			$linea[0],
			$linea[1],
			$linea[2],
			$linea[3],
			$linea[4],
			$linea[5],
			$linea[6],
			$linea[7],
			$linea[8],
			$linea[9],
			$linea[10],
			$linea[19],
			$linea[20],
			$lote,
			$json_datos_reportables
		];
		return $prestacion;
	}

	/**
	 * Abre un archivo y devuelve un handler
	 * @param int $id
	 *
	 * @return resource
	 */
	protected function abrirArchivo($id){
		$info = Subida::findOrFail($id);
		try {
			$fh = fopen ('../storage/uploads/prestaciones/' . $info->nombre_actual , 'r');
		} catch (ErrorException $e) {
			return false;
		}
		return $fh;
	}


	/**
	 * Procesa el archivo de prestaciones
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id){
		$lote = $this->nuevoLote($id);
		$fh = $this->abrirArchivo($id);
		
		if (!$fh){
			return response('Error' , 422);
		}

		fgets($fh);
		while (!feof($fh)){
			$linea = explode (';' , trim(fgets($fh) , "\r\n"));
			if (count($linea) != 1) {
				$prestacion_raw = array_combine($this->_data, $this->armarArray($linea , $lote));
				$v = Validator::make($prestacion_raw , $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados'] ++;
					$this->_error['lote'] = $lote;
					$this->_error['registro'] = json_encode($prestacion_raw);
					$this->_error['motivos'] = json_encode($v->errors());
					$this->_error['created_at'] = date("Y-m-d H:i:s");
					Rechazo::insert($this->_error);
				} else {
					$operacion = array_shift($prestacion_raw);
					switch ($operacion) {
						case 'A':
							try {
								Prestacion::insert($prestacion_raw);
								$this->_resumen['insertados'] ++;
							} catch (QueryException $e) {
								$this->_resumen['rechazados'] ++;
								$this->_error['lote'] = $lote;
								$this->_error['registro'] = json_encode($prestacion_raw);
								$this->_error['created_at'] = date("Y-m-d H:i:s");
								if ($e->getCode() == 23505){
									$this->_error['motivos'] = '{"pkey" : ["Registro ya informado"]}';
								} else {
									$this->_error['motivos'] = '{"' . $e->getCode() . '" : ["' . $e->getMessage() . '"]}';
								}
								Rechazo::insert($this->_error);
							}
							break;
						case 'M':
							$prestacion = Prestacion::where('numero_comprobante' , $prestacion_raw['numero_comprobante'])
													->where('codigo_prestacion' , $prestacion_raw['codigo_prestacion'])
													->where('subcodigo_prestacion' , $prestacion_raw['subcodigo_prestacion'])
													->where('fecha_prestacion' , $prestacion_raw['fecha_prestacion'])
													->where('clave_beneficiario' , $prestacion_raw['clave_beneficiario'])
													->where('orden' , $prestacion_raw['orden']);
							
							if ($prestacion->count()){
								$prestacion = $prestacion->firstOrFail();
								$prestacion->estado = 'D';
								if ($prestacion->save()){
									$this->_resumen['modificados'] ++;
								}
							} else {
								$this->_resumen['rechazados'] ++;
								$this->_error['lote'] = $lote;
								$this->_error['registro'] = json_encode($prestacion_raw);
								$this->_error['motivos'] = '{"modificacion" : ["Registro a modificar no encontrado"]}';
								$this->_error['created_at'] = date("Y-m-d H:i:s");
								Rechazo::insert($this->_error);
							}
							break;
					}
				}
			}
		}
		$this->actualizaLote($lote , $this->_resumen);
		$this->actualizaSubida($id);
		return response()->json($this->_resumen);
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
		return view('prestaciones.periodo' , $data);
	}

	/**
     * Devuelve listado de 6 meses 
     *
     * @return json
     */
    protected function getMesesArray($periodo){

        $dt = \DateTime::createFromFormat('Y-m' , $periodo);
        $dt->modify('-13 month');
        for ($i = 0 ; $i < 12 ; $i ++){
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
        $dt->modify('-11 months');
        $interval['min'] = $dt->format('Ym');

        return $interval;
    }

	/**
     * Devuelve la info para generar un gráfico
     * 
     * @return json
     */
    protected function getProgresoPrestaciones($periodo){

        $interval = $this->getDateInterval($periodo);

        $periodos = Fc001::select('periodo' , DB::raw('sum(cantidad) as b'))
                    ->whereBetween('periodo',[$interval['min'],$interval['max']])
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();

        foreach($periodos as $key => $periodo){
            $chart[0]['name'] = 'Prest. Fact.';
            $chart[0]['data'][$key] = $periodo->b;
            
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
    	$provincias_ceb = Fc001::where('periodo' , $periodo)->get();

    	foreach ($provincias_ceb as $key => $provincia){
    		$chart[0]['name'] = 'Prest. Fact.';
            $chart[0]['data'][$key] = $provincia->cantidad;
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
        $regiones = Fc005::where('periodo' , $periodo)
                        ->join('geo.provincias as p' , 'estadisticas.fc_005.id_provincia' , '=' , 'p.id_provincia')
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
            $provincias = Fc005::where('periodo' , $periodo)
                            ->where('r.id_region' , $j)
                            ->join('geo.provincias as p' , 'estadisticas.fc_005.id_provincia' , '=' , 'p.id_provincia')
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
            $codigos = Fc005::where('periodo' , $periodo)
                            ->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
                            ->join('geo.provincias as p' , 'estadisticas.fc_005.id_provincia' , '=' , 'p.id_provincia')
                            ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                            ->join('pss.codigos as cg' , 'estadisticas.fc_005.codigo_prestacion' , '=' , 'cg.codigo_prestacion')
                            ->select('r.id_region' , 'p.id_provincia' , 'estadisticas.fc_005.codigo_prestacion' , 'cg.descripcion_grupal' , DB::raw('sum(cantidad) as cantidad'))
                            ->groupBy('r.id_region')
                            ->groupBy('p.id_provincia')
                            ->groupBy('estadisticas.fc_005.codigo_prestacion')
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
                $grupos = Fc005::where('periodo' , $periodo)
                                ->where('p.id_provincia' , str_pad($k , 2 , '0' , STR_PAD_LEFT))
                                ->where('codigo_prestacion' , $matriz_aux[$l])
                                ->join('geo.provincias as p' , 'estadisticas.fc_005.id_provincia' , '=' , 'p.id_provincia')
                                ->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
                                ->join('pss.grupos_etarios as g' , 'estadisticas.fc_005.grupo_etario' , '=' , 'g.sigla')
                                ->select('r.id_region' , 'p.id_provincia' , 'estadisticas.fc_005.codigo_prestacion' , 'g.descripcion' , DB::raw('sum(cantidad) as cantidad'))
                                ->groupBy('r.id_region')
                                ->groupBy('p.id_provincia')
                                ->groupBy('estadisticas.fc_005.codigo_prestacion')
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
     * Devuelve la info para el grafico de torta
     * @param string $periodo
     *
     * @return json
     */
    protected function getDistribucionGruposEtarios($periodo){
    	$periodo = str_replace("-", '', $periodo);
    	$grupos = Fc005::select(DB::raw('substring(grupo_etario from 1 for 1) as name') , DB::raw('sum(cantidad)::int as y'))
    					->where('periodo' , $periodo)
    					->groupBy(DB::raw(1))
    					->orderBy(DB::raw(1))
    					->get();
    	
    	return json_encode($grupos);
    }

    /**
     * Devuelve la info para el gráfico por sexo
     * @param string $periodo
     *
     * @return json
     */
    protected function getSexosSeries($periodo){
    	$periodo = str_replace("-", '', $periodo);
    	$grupos = ['A','B','C','D'];

    	foreach ($grupos as $grupo) {

	    	$sexos = Fc005::where('periodo' , $periodo)
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
	 * Devuelve la info para la datatable
	 *
	 * @return json
	 */
	public function getResumenTabla($periodo){
		$periodo = str_replace("-", '', $periodo);
		$registros = Fc005::where('periodo' , $periodo);
		return Datatables::of($registros)->make(true);
	}

	/** 
	 * Devuelve la vista del resumen
	 * @param string $periodo
	 *
	 * @return null
	 */
	public function getResumen($periodo){
		$dt = \DateTime::createFromFormat('Y-m' , $periodo);

		$data = [
			'page_title' => 'Resumen mensual facturación prestaciones, ' . ucwords(strftime("%B %Y" , $dt->getTimeStamp())),
			'progreso_prestaciones_series' => $this->getProgresoPrestaciones($periodo),
			'progreso_prestaciones_categorias' => $this->getMesesArray($periodo),
			'distribucion_provincial_categorias' => $this->getProvinciasArray(),
			'distribucion_provincial_series' => $this->getDistribucionProvincial($periodo),
			'treemap_data' => $this->getDistribucionCodigos($periodo),
			'pie_grupos_etarios' => $this->getDistribucionGruposEtarios($periodo),
			'distribucion_sexos' => $this->getSexosSeries($periodo),
			'periodo' => $periodo

		];
		return view('prestaciones.resumen' , $data);
	}

	/**
     * Devuelve la info para graficar
     * 
     * @return json
     */
    protected function getProgresionPrestacionesSeries(){

        $dt = new \DateTime();
        $dt->modify('-1 month');

        $interval = $this->getDateInterval($dt->format('Y-m'));

        $provincias = Provincia::orderBy('id_provincia')->get();

        foreach ($provincias as $key => $provincia){

        	$periodos = Fc001::where('estadisticas.fc_001.id_provincia' , $provincia->id_provincia)
        					->join('geo.provincias as p' , 'estadisticas.fc_001.id_provincia' , '=' , 'p.id_provincia')
        					->join('geo.regiones as r' , 'p.id_region' , '=' , 'r.id_region')
        					->select('estadisticas.fc_001.*' , 'p.nombre as nombre_provincia' , 'r.*')
    						->whereBetween('periodo' , [$interval['min'] , $interval['max']])
    						->get();
        	foreach ($periodos as $periodo){
        		$series['provincias'][$key]['series'][0]['data'][] = $periodo->cantidad;
        		$series['provincias'][$key]['series'][0]['name'] = 'Prestaciones';
        		$series['provincias'][$key]['series'][0]['color'] = $periodo->color;
        		$series['provincias'][$key]['series'][0]['marker']['enabled'] = false;
        		$series['provincias'][$key]['elem'] = 'provincia' . $periodo->id_provincia;
        		$series['provincias'][$key]['categorias'] = $this->getMesesArray(date('Y-m'));
        		$series['provincias'][$key]['provincia'] = $periodo->nombre_provincia;
        		$series['provincias'][$key]['css'] = $periodo->css;

        	}

        }
        return json_decode(json_encode($series , JSON_PRETTY_PRINT));
        //return json_encode($series , JSON_PRETTY_PRINT);
    }

    /** 
     * Devuelve la vista de evolución
     *
     * @return null
     */
    public function getEvolucion(){

    	//return '<pre>' . $this->getProgresionPrestacionesSeries() . '</pre>';
        
        $dt = new \DateTime();
        $dt->modify('-1 month');
        $max = strftime("%b %Y" , $dt->getTimeStamp());
        $dt->modify('-11 months');
        $min = strftime("%b %Y" , $dt->getTimeStamp());

        $data = [
            'page_title' => 'Evolución: Período ' . $min . ' - ' . $max ,
            'series' => $this->getProgresionPrestacionesSeries()
        ];

        return view('prestaciones.evolucion' , $data);
    }


}
