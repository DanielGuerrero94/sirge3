<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Mail;
use Auth;
use Datatables;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Prestacion;
use App\Models\Geo\Provincia;

use App\Models\CEI\Grupo;
use App\Models\CEI\Linea;
use App\Models\CEI\Resultado;
use App\Models\CEI\Indicador;
use App\Models\CEI\Detalle;
use App\Models\CEI\Tipo;


class CeiController extends Controller
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
	 * Devuelve la vista para el Resumen mensual
	 * 
	 * @return null
	 */
	public function getFiltros(){

		$periodos = Resultado::select('periodo' , DB::raw('round((count(*) / 1728 :: numeric * 100) ,2) as r'))
							->groupBy('periodo')
							->take(3)
							->get();

		foreach ($periodos as $periodo){
			$dt = \DateTime::createFromFormat('Ym' , $periodo->periodo);
			$periodo->periodo = ucwords(strftime("%b %Y" , $dt->getTimeStamp()));

			if ($periodo->r < 100){
				$periodo->css = 'bg-yellow';
			} else {
				$periodo->css = 'bg-lime';
			}
		}

		$data = [
			'page_title' => 'Resumen C.E.I.',
			'provincias' => Provincia::orderBy('id_provincia')->get(),
			'grupos' => Grupo::all(),
			'periodos' => $periodos
		];

		return view('cei.filtros' , $data);
	}

	/**
	 * Devuelve las lineas de cuidado asociadas a un grupo etario
	 * @param int $grupo
	 * 
	 * @return null
	 */
	public function getLineas($grupo){
		$lineas = Linea::where('grupo_etario' , $grupo)->get();
		return response()->json($lineas);
	}

	/**
	 * Devuelve la información para graficar los mapas
	 * @param int $periodo 
	 * @param int $linea
	 *
	 * @return array
	 */
	protected function getMapSeries($periodo , $linea){

		$indicadores = Indicador::where('indicador' , $linea)->orderBy('id' , 'asc')->lists('id');

		foreach ($indicadores as $key => $indicador) {

			$resultados = Resultado::join('geo.geojson as g' , 'cei.resultados.provincia' , '=' , 'g.id_provincia')
									->where('indicador' , $indicador)
									->where('periodo' , $periodo)
									->orderBy('provincia' , 'asc')
									->get();

			// return '<pre>' . json_encode($resultados , JSON_PRETTY_PRINT) . '</pre>';

			foreach ($resultados as $key_provincia => $resultado){

				if ($resultado->resultados->denominador == 0) {
					$map[$indicador]['map-data'][$key_provincia]['value'] = 0;
				} else {
					$map[$indicador]['map-data'][$key_provincia]['value'] = round($resultado->resultados->beneficiarios_puntuales / $resultado->resultados->denominador , 4) * 100;
				}
				
				$map[$indicador]['map-data'][$key_provincia]['hc-key'] = $resultado->geojson_provincia;
				$map[$indicador]['map-data'][$key_provincia]['indicador'] = $indicador;
				$map[$indicador]['map-data'][$key_provincia]['periodo'] = $periodo;
				$map[$indicador]['map-data'][$key_provincia]['provincia'] = $resultado->provincia;
			}

			$map[$indicador]['map-data'] = json_encode($map[$indicador]['map-data']);
			$map[$indicador]['clase'] = $key;
		}

		return $map;

	}

	/**
	 * Devuelve la información para armar los gráficos de barra
	 * @param int $periodo 
	 * @param int $linea
	 *
	 * @return array
	 */
	protected function getGraficoSeries($periodo , $linea){

		$indicadores = Indicador::where('indicador' , $linea)->orderBy('id' , 'asc')->lists('id');
		$data['categorias'] = Provincia::orderBy('id_provincia')->lists('descripcion');

		foreach ($indicadores as $key => $indicador) {

			$resultados = Resultado::join('geo.provincias as p' , 'cei.resultados.provincia' , '=' , 'p.id_provincia')
									->where('indicador' , $indicador)
									->where('periodo' , $periodo)
									->orderBy('provincia' , 'asc')
									->get();

			foreach ($resultados as $key_provincia => $resultado){

				if ($resultado->resultados->denominador == 0) {
					$data['info'][$indicador]['serie']['data'][] = 0;
				} else {
					$data['info'][$indicador]['serie']['data'][] = round($resultado->resultados->beneficiarios_puntuales / $resultado->resultados->denominador , 4) * 100;
					$data['info'][$indicador]['serie']['name'] = 'Resultados';
				}
			}

			$data['info'][$indicador]['serie'] = json_encode($data['info'][$indicador]['serie']);
			$data['info'][$indicador]['clase'] = $key;
		}

		return $data;

	}

	/**
	 * Devuelve la vista resumen
	 * @param int $periodo
	 * @param int $linea
	 *
	 * @return null
	 */
	public function getResumen($periodo , $linea){

		$dt = \DateTime::createFromFormat('Y-m' , $periodo);
		$periodo = $dt->format('Ym');
		
		// return $this->getGraficoSeries($periodo , $linea);

		$data = [
			'maps' => $this->getMapSeries($periodo , $linea),
			'graficos' => $this->getGraficoSeries($periodo , $linea)
		];

		return view('cei.resumen' , $data);
	}

	/**
	 * Devuelve un pequeño detalle del indicador para una provincia y un período
	 * @param int $periodo
	 * @param int $indicador
	 * @param char $provincia
	 *
	 * @return null
	 */
	public function getDetalleProvincia($periodo , $indicador , $provincia){
		$resultado = Resultado::where('provincia' , $provincia)
							->where('indicador' , $indicador)
							->where('periodo' , $periodo)
							->firstOrFail();
		$provincia = Provincia::find($provincia);

		foreach ($resultado->resultados->prestaciones->codigos as $codigo => $cantidad) {
			$data['serie'][0]['name'] = 'Fact. Prest.';
			$data['serie'][0]['data'][] = $cantidad;
			$data['categorias'][] = $codigo;
			$data['provincia'] = $provincia->descripcion;
		}

		$data = [
			'indicador' => $indicador,
			'serie' => $data,
			'beneficiarios_oportunos' => $resultado->resultados->beneficiarios_oportunos,
			'beneficiarios_puntuales' => $resultado->resultados->beneficiarios_puntuales,
			'denominador' => $resultado->resultados->denominador
		];

		return view('cei.detalle-provincia' , $data);

	}

	/**
	 * Devuelve la vista para descargar reportes
	 *
	 * @return null
	 */
	public function getReportes(){

		$data = [
			'page_title' => 'Resultados C.E.I.'
		];

		return view('cei.reportes' , $data);
	}

	/**
	 * Devuelve el objeto para el Datatable
	 *
	 * @return json
	 */
	public function getReportesTabla(){

		$detalles = Detalle::select(
				'id' 
				, 'nombre' 
				, DB::raw("case when (edad_max = '0 years') then edad_min else (edad_min :: interval - edad_max :: interval + '1 year') :: text	end as edad_min") 
				, DB::raw("edad_min :: interval + '1 year' as edad_max"));
		
		return Datatables::of($detalles)
			->addColumn('action' , function($detalle){
				return '<button id="'. $detalle->id .'" class="ver-indicador btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i></button>';
			})
			->make(true);
	}

	/**
	 * Devuelve la vista con el detalle de los cálculos
	 * @param int $id
	 * 
	 * @return null
	 */
	public function getReporte($id){

		$periodos = Resultado::select('periodo')->groupBy('periodo')->lists('periodo');
		$tipos = Tipo::orderBy('id')->get();
		$detalle = Detalle::findOrFail($id);

		foreach ($periodos as $keyp => $periodo){

			foreach ($tipos as $keyt => $tipo){

				$indicador = Indicador::where('indicador' , $id)->where('tipo' , $tipo->id)->firstOrFail();
				$registros = Resultado::where('indicador' , $indicador->id)
							->where('periodo' , $periodo)
							->get();

				foreach ($registros as $registro) {
					if ($registro->resultados->denominador == 0) {
						$promedio[] = 0;
					} else {
						$promedio[] = round(($registro->resultados->beneficiarios_puntuales / $registro->resultados->denominador) * 100,2);
					}
				}

				$array_final[$tipo->id]['resultados'][$keyp]['periodo'] = $periodo;
				$array_final[$tipo->id]['resultados'][$keyp]['valor'] = round(array_sum($promedio) / count($promedio),2);
				$array_final[$tipo->id]['tipo'] = $tipo->descripcion;
				$array_final[$tipo->id]['css'] = $tipo->css;
				$array_final[$tipo->id]['indicador'] = $indicador->id;
				
			}

		}

		$objeto = json_decode(json_encode($array_final));

		$data = [
			'page_title' => $detalle->nombre,
			'objetos' => $objeto
		];

		return view ('cei.reporte-detalle' , $data);

	}
}
