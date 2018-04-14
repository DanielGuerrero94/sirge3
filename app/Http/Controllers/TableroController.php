<?php

namespace App\Http\Controllers;

use App\Exceptions\MyShellException;
use App\Models\Geo\Provincia;
use App\Models\Lote;
use App\Models\Rechazo;

use App\Models\Subida;
use App\Models\Tablero\Administracion;
use App\Models\Tablero\Detail;
use App\Models\Tablero\Ingreso;
use App\Models\Tablero\Rango;
use App\Models\Tablero\VWIngreso;
use App\Models\Tablero\YearIndicadores;
use App\Models\Usuario;

use Auth;
use Datatables;
use DateTime;
use DB;
use Excel;
use Illuminate\Http\Request;
use Log;
use Mail;
use Validator;

class TableroController extends AbstractPadronesController {
	private $_rules,
	$_messages = [
		'periddo'   => 'El formato de fecha debe ser DD-MM-YYYY',
		'indicador' => 'El indicador es invalido'
	],
	$_data = [
		'periodo',
		'indicador',
		'provincia',
		'numerador',
		'denominador',
		'lote'
	],
	$_resumen = [
		'insertados'  => 0,
		'rechazados'  => 0,
		'modificados' => 0
	],
	$_error = [
		'lote'     => '',
		'registro' => '',
		'motivos'  => ''
	],
	$_process_data = [
		'FILE_DIR'        => '/var/www/html/sirge3/storage/uploads/tablero/',
		'FILE_NAME'       => '',
		'FILE_PATH'       => '',
		'TABLE_NAME'      => 'vw_ingresos',
		'NUMBER_LOTE'     => '',
		'LOGIC_DIR'       => '/var/www/html/sirge3/storage/uploads/tablero/process_logic/',
		'LOGIC_FILE_NAME' => 'carga_indicador.load'
	],
	$_id,
	$_indicador,
	$_year,
	$_provincia,
	$_user;

	/**
	 * Constructor.
	 *
	 *
	 */
	public function __construct() {
		$this->_id        = 0;
		$this->_indicador = '';
		$this->_year      = 0;
		$this->_provincia = '';
		$this->_user      = NULL;
		$this->_rules     = ['periodo' => 'required|date_format:d/m/Y|before:'.date("Y/m/d").'|after:2004-01-01',
			'provincia'                   => 'required|max:100',
			'indicador'                   => 'required|exists:tablero.descripcion,indicador',
			'numerador'                   => 'required_without:denominador|valor_tablero',
			'denominador'                 => 'required_without:numerador|valor_tablero',
			'lote'                        => 'required|integer'];
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data = [
			'page_title'   => 'Seleccione el periodo a visualizar',
			'id_provincia' => Auth::user()->id_provincia,
			'provincias'   => Provincia::all()
		];
		return view('tablero.select-periodo', $data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function main($periodo, $provincia) {

		if (Ingreso::where('periodo', $periodo)->count() == 0 && Auth::user()->id_menu != 1) {return 'error';}

		$indicadores_full = $this->indicadoresFull($periodo, $provincia);

		$data = [
			'page_title'       => 'Ingresos: Tablero de Control',
			'periodo'          => $periodo,
			'provincia'        => $provincia,
			'user'             => Auth::user(),
			'indicadores_full' => $indicadores_full
		];
		return view('tablero.listado', $data);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function indicadoresFull($periodo, $provincia) {

		$indicadores_full = 'false';
		$indicadores      = YearIndicadores::find(substr($periodo, 0, 4));

		if ($indicadores) {
			$array_indicadores          = array_values(explode(',', substr($indicadores->indicadores, 1, -1)));
			$array_indicadores_cargados = array_values(Ingreso::where('periodo', $periodo)->where('provincia', $provincia)->lists('indicador')->toArray());
			sort($array_indicadores);
			sort($array_indicadores_cargados);
			$indicadores_full = ($array_indicadores == $array_indicadores_cargados)?'true':'false';
		}

		if ($indicadores_full == 'true' && Administracion::where('periodo', $periodo)
				->where('provincia', $provincia)->where('estado', 3)->count() > 0) {
			$indicadores_full = 'completed';
		}

		return $indicadores_full;
	}

	/**
	 * Muestra el formulario de modificacion del indicador.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getModificar($id) {
		$indicador = Ingreso::find($id);
		$data      = [
			'page_title' => 'Modificacion del indicador',
			'ruta_back'  => 'main-tablero/'.$indicador->periodo.'/'.$indicador->provincia,
			'provincias' => Provincia::all(),
			'user'       => Auth::user(),
			'indicador'  => $indicador];

		return view('tablero.modificar', $data);
	}

	/**
	 * Muestra el formulario de modificacion del indicador.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postModificar(Request $r) {

		try {
			$unIndicador              = Ingreso::find($r->id);
			$unIndicador->periodo     = $r->periodo;
			$unIndicador->numerador   = $r->numerador;
			$unIndicador->denominador = $r->denominador;
			$unIndicador->save();
		} catch (\Exception $e) {
			return json_encode(["resultado" => 'Ha ocurrido un error']);
		}
		return 'Se han modificado los datos correctamente.';
	}

	/**
	 * Devuelve un json para la datatable
	 *
	 * @return json
	 */
	public function listadoTabla($periodo, $provincia) {

		$results = $this->datosListadoTabla($periodo, $provincia);

		return Datatables::of($results)
			->addColumn(
			'indicador_real',
			function ($result) {
				$indicador_real = strtr($result->indicador, array("|" => "."));
				return $indicador_real;
			}
		)
			->addColumn(
			'numerador_format',
			function ($result) {
				if (in_array($result->indicador, ['5|1', '5|3'])) {
					return empty($result->numerador)?null:($result->numerador);
				} else if (in_array($result->indicador, ['1|1', '1|2', '2|1', '2|2', '2|3', '2|4'])) {
					return empty($result->numerador)?null:(number_format($result->numerador, 0, ',', '.'));
				}
				return empty($result->numerador)?null:('$ '.number_format($result->numerador, 2, ',', '.'));

			}
		)
			->addColumn(
			'denominador_format',
			function ($result) {
				if (in_array($result->indicador, ['5|1', '5|3'])) {
					return empty($result->denominador)?null:($result->denominador);
				} else if (in_array($result->indicador, ['1|1', '1|2', '2|1', '2|2', '2|3', '2|4', '5|4', '5|5'])) {
					return empty($result->denominador)?null:(number_format($result->denominador, 0, ',', '.'));
				}
				return empty($result->denominador)?null:('$ '.number_format($result->denominador, 2, ',', '.'));
			}
		)
			->addColumn(
			'estado',
			function ($result) {
				$var_state = $this->checkState($result->id);
				return '<button class="btn btn-'.$var_state['color'].' btn-xs"> '.$var_state['value'].'</button>';
			}
		)
			->addColumn(
			'action',
			function ($result) {
				return $this->datatableActions($this->indicadoresFull($result->periodo, $result->provincia), $this->_user->id_area, $this->_user->id_entidad, $result->observaciones, $result->id);
			}
		)
			->make(true);
	}

	/**
	 * Rechazar indicadores del periodo
	 * @param object $r
	 *
	 * @return void
	 */
	public function datosListadoTabla($periodo, $provincia) {

		$results = Ingreso::select('id', 'periodo', 'provincia', DB::raw("replace(indicador,'.','|') as indicador"), 'numerador', 'denominador', 'observaciones')
			->with(['provincias']);

		if ($provincia != 99) {
			$results->where('provincia', $provincia);
		}
		if ($periodo != '9999-99') {
			$results->where('periodo', $periodo);
		}

		$results->orderBy('periodo', 'desc')
		        ->orderBy('provincia', 'asc')
		        ->orderBy(DB::raw('left(indicador,1)::integer'), 'asc')
		        ->orderBy(DB::raw('right(indicador,-2)::integer'), 'asc');

		$this->_user = Auth::user();

		return $results;
	}

	/**
	 * Arma el excel de ingresos
	 * @param variables $r
	 *
	 * @return excel
	 */
	public function excelListadoTabla($periodo, $provincia) {

		$results = $this->datosListadoTabla($periodo, $provincia);
		$results = collect($results->get());
		$results->transform(function ($item, $key) {
				$item->estado = $this->checkStateValue($item);
				$item->indicador = strtr($item->indicador, array("|" => "."));
				return $item;
			});

		$data = ['tablero' => $results, 'id_entidad' => Auth::user()->id_entidad, 'periodo' => $periodo];
		$name = 'Ingresos en $periodo - Tablero de Control SUMAR';

		Excel::create("Indicadores - $provincia - " .date('Y-m-d'), function ($e) use ($data) {
				$e->sheet('Ingresos_SUMAR', function ($s) use ($data) {
						$s->loadView('tablero.tabla_ingresos', $data);
						$s->setColumnFormat(array('A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@'));
					});
			})
			->export('xls');
	}

	/**
	 * Devuelve el codigo HTML de los botones de accion de la datatable
	 *
	 * @return text (HTML)
	 */
	public function datatableActions($indicadores_full, $id_area, $id_entidad, $observaciones, $id) {

		if (!in_array($indicadores_full, array('completed', 'rejected'))) {

			if (in_array($id_area, array(1, 16, 19)) && $id_entidad == 2) {
				$botones = '<button id="'.$id.'" class="modificar-indicador btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Editar</button> ';
				if (count($observaciones)) {
					$botones .= '<button id="'.$id.'" class="observar-indicador btn bg-grey btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Ver observaciones"> <i class="fa fa-envelope-o"></i></button> ';
				}
			} else if (in_array($id_area, array(19)) && $id_entidad == 1) {
				$botones = '<button id="'.$id.'" class="observar-indicador btn bg-primary btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Detalle una observacion para alertar a la provincia"> <i class="fa fa-eye"></i>  OBSERVAR</button> ';
				if (count($observaciones)) {
					$botones .= ' <i class="fa fa-exclamation-circle" style="color:red" data-toggle="listado-tooltip" data-placement="top" title="Hay mensajes intercambiados"></i>';
				}
			} else if (in_array($id_area, array(1)) && $id_entidad == 1) {
				$botones = ' <button id="'.$id.'" class="modificar-indicador btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Editar</button> ';
				$botones .= ' <button id="'.$id.'" class="observar-indicador btn bg-primary btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Detalle una observacion para alertar a la provincia"><i class="fa fa-eye"></i> OBSERVAR</button> ';
			}
		} else {
			if ($indicadores_full == 'completed') {
				$botones = ' <button id="'.$id.'" class="modificar-indicador btn btn-success btn-xs"> ACEPTADO</button> ';
			} else {
				$botones = ' <button id="'.$id.'" class="modificar-indicador btn btn-danger btn-xs"> RECHAZADO</button> ';
			}

		}
		return $botones;
	}

	/**
	 * Retorna un array con el resultado y el color de la meta alcanzada
	 *
	 * @return array()
	 */
	public function checkState($id) {
		$id = Ingreso::where('id', $id)->select('id', 'periodo', DB::raw("replace(indicador,'.','|') as indicador"), 'provincia', 'numerador', 'denominador')->with(['provincias'])->first();

		$var_result['value'] = $this->checkStateValue($id);

		$conv = array("|" => ".");

		$this->_id        = $id;
		$this->_indicador = strtr($id->indicador, $conv);
		$this->_year      = intval(substr($id->periodo, 0, 4));
		$this->_provincia = $id->provincia;

		$var_result['color'] = $this->stateColor($var_result['value']);

		return $var_result;
	}

	/**
	 * Retorna un valor
	 *
	 * @return integer
	 */
	public function checkStateValue($id) {
		$var_result = [];

		$indicador = strtr($id->indicador, array("." => "|"));

		if (in_array($indicador, ['5|1', '5|3'])) {
			$datetime_denominador = DateTime::createFromFormat('d/m/Y', $id->denominador);
			$datetime_numerador   = DateTime::createFromFormat('d/m/Y', $id->numerador);
			$interval_diff        = $datetime_numerador->diff($datetime_denominador);
			$value                = $interval_diff->format('%a');
			return $value;
		} elseif (in_array($indicador, ['5|4', '5|5'])) {
			return (!empty($id->denominador) && !empty($id->numerador))?round((float) $id->numerador/(float) $id->denominador, 2):'INCOMPLETO';
		} else {
			return (!empty($id->denominador) && !empty($id->numerador))?round((float) $id->numerador/(float) $id->denominador*100, 2):'INCOMPLETO';
		}
	}

	/**
	 * Retorna el color correspondiete al boton (formato font-awesome) que determina si se cumplio o no la meta del indicador
	 *
	 * @return array()
	 */
	public function stateColor($value) {
		$rango = Rango::where('id_provincia', $this->_provincia)
		                                           ->where('year', $this->_year)
			->where('indicador', $this->_indicador)
		//->where('indicador','2.5') //$this->_indicador)
			->firstOrFail();

		$red_eval_string    = $this->eval_color(json_decode($rango->red), $value);
		$yellow_eval_string = $this->eval_color(json_decode($rango->yellow), $value);
		$green_eval_string  = $this->eval_color(json_decode($rango->green), $value);

		switch (true) {
			case ($value === 'INCOMPLETO'):
				return 'default incompleto';
				break;

			case ($value === 0):
			case eval("return ($red_eval_string);"):
				return 'danger';
				break;

			case eval("return ($yellow_eval_string);"):
				return 'warning';
				break;

			case eval("return ($green_eval_string);"):
				return 'success';
				break;

			default:
				return 'default';
				break;
		}
	}

	public function eval_color($condiciones, $value) {

		$eval_string  = '';
		$eval_string2 = '';

		if (isset($condiciones['0'])) {

			if (isset($condiciones['0']->multiple_condicion_1)) {
				$condicion_1 = $condiciones['0']->multiple_condicion_1;
			} else {
				$condicion_1 = $condiciones;
			}

			foreach ($condicion_1 as $obj_cond) {

				if ($eval_string != '') {
					$eval_string .= " && ";
				} else {
					$eval_string .= "( ";
				}
				$eval_string .= "(".$value." ".$obj_cond->condicion." ".$obj_cond->valor.")";
			}

			if (isset($condiciones['0']->multiple_condicion_2)) {

				$eval_string .= " ) || ( ";

				foreach ($condiciones['0']->multiple_condicion_2 as $obj_cond) {
					if ($eval_string2 != '') {
						$eval_string .= " && ";
					} else {
						$eval_string2 .= "( ";
					}
					$eval_string_2 = "(".$value." ".$obj_cond->condicion." ".$obj_cond->valor.")";
					$eval_string .= $eval_string_2;
				}
			}
			$eval_string .= " )";

		}
		//var_dump(array("eval_string_final:" => $eval_string));
		return $eval_string;
	}

	/**
	 * Muestra el formulario de modificacion del indicador.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getObservacion($id) {
		$indicador = Ingreso::find($id);
		$data      = [
			'page_title' => 'Modificacion del indicador',
			'ruta_back'  => 'main-tablero/'.$indicador->periodo.'/'.$indicador->provincia,
			'reload'     => 'tablero-observar-indicador/'.$id,
			'provincias' => Provincia::all(),
			'user'       => Auth::user(),
			'indicador'  => $indicador,
			'estado'     => (object) $this->checkState($id)];

		return view('tablero.observacion', $data);
	}

	/**
	 * Muestra el formulario de modificacion del indicador.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function postObservacion(Request $r) {

		$indicador                                     = Ingreso::find($r->id);
		$observaciones                                 = json_decode($indicador->observaciones, true);
		if (!is_array($observaciones)) {$observaciones = array();
		}

		array_push($observaciones, ["fecha" => date("Y-m-d H:i:s"), "id_usuario" => Auth::user()->id_usuario, "mensaje" => $r->observacion]);
		$indicador->observaciones = json_encode($observaciones);
		if ($indicador->save()) {

			if (Auth::user()->id_entidad == 2) {
				//$cadena_uec = Usuario::where('id_entidad', 1)->where('id_area',19)->where('activo','S')->orderBy('id_usuario', 'asc')->lists('email');
				$cadena_uec = Usuario::where('id_usuario', Auth::user()->id_usuario)->lists('email');

				Mail::send('emails.respuesta-observacion', ['user' => Auth::user(), 'indicador' => $indicador, 'mensaje' => $r->observacion], function ($m) use ($cadena_uec) {
						$m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
						foreach ($cadena_uec as $supervision_uec) {
							$m->to($supervision_uec);
						}
						$m->bcc('rodrigo.cadaval.sumar@gmail.com');
						$m->subject('Respuesta a observacion en Tablero de Control!');
					});
			} else {
				//$cadena_ugsp = Usuario::where('id_entidad', 2)->whereIn('id_area',[1,19])->where('id_provincia',$indicador->provincia)->where('activo','S')->orderBy('id_usuario', 'asc')->lists('email');
				$cadena_ugsp = Usuario::where('id_usuario', Auth::user()->id_usuario)->lists('email');

				Mail::send('emails.observacion', ['user' => Auth::user(), 'indicador' => $indicador, 'mensaje' => $r->observacion], function ($m) use ($cadena_ugsp) {
						$m->from('sirgeweb@sumar.com.ar', 'Programa SUMAR');
						foreach ($cadena_ugsp as $supervision_ugsp) {
							$m->to($supervision_ugsp);
						}
						$m->bcc('rodrigo.cadaval.sumar@gmail.com');
						$m->subject('Observacion en Tablero de Control!');
					});
			}

			return "Observacion realizada correctamente";
		}
	}

	/**
	 * Abre un archivo y devuelve un handler
	 * @param int $id
	 *
	 * @return resource
	 */
	protected function abrirArchivo($id) {
		$info = Subida::findOrFail($id);

		try {
			$fh = fopen('/var/www/html/sirge3/storage/uploads/tablero/'.$info->nombre_actual, 'r');
		} catch (ErrorException $e) {
			return false;
		}
		return $fh;
	}

	/**
	 * Procesa el archivo del tablero
	 * @param int $id
	 *
	 * @return json
	 */
	public function procesarArchivo($id) {

		$fh = $this->abrirArchivo($id);
		Log::info($id);
		Log::info(Lote::where('id_subida', $id)->first());
		$lote = Lote::where('id_subida', $id)->first()->lote;

		if (!$fh) {
			return response()->json(['success' => 'false', 'errors' => "El archivo no ha podido procesarse"]);
		}
		$nro_linea = 1;

		fgets($fh);
		while (!feof($fh)) {
			$nro_linea++;
			$linea                      = explode("\t", trim(fgets($fh), "\r\n"));
			$linea                      = array_map('trim', $linea);
			$this->_error['lote']       = $lote;
			$this->_error['created_at'] = date("Y-m-d H:i:s");
			if ((count($this->_data)-1) == count($linea)) {
				array_push($linea, $lote);
				$tablero_raw = array_combine($this->_data, $linea);
				$v           = Validator::make($tablero_raw, $this->_rules);
				if ($v->fails()) {
					$this->_resumen['rechazados']++;
					$this->_error['registro'] = json_encode($tablero_raw);
					$this->_error['motivos']  = json_encode($v->errors());
					try {
						Rechazo::insert($this->_error);
					} catch (QueryException $e) {
						if ($e->getCode() == 23505) {
							$this->_error['motivos'] = '{"pkey" : ["Registro ya informado"]}';
						} else if ($e->getCode() == 22021 || $e->getCode() == '22P05') {
							$this->_error['registro'] = json_encode(parent::vaciarArray($tablero_raw));
							$this->_error['motivos']  = json_encode(array('code' => $e->getCode(), 'linea' => $nro_linea, 'error' => 'El formato de caracteres es inválido para la codificación UTF-8. No se pudo convertir. Intente convertir esas lineas a UTF-8 y vuelva a procesarlas.'));
						} else {
							$this->_error['motivos'] = json_encode(array('code' => $e->getCode(), 'error' => $e->getMessage()));
						}
						Rechazo::insert($this->_error);
					}
				} else {
					try {
						VWIngreso::insert($tablero_raw);
						$this->_resumen['insertados']++;
					} catch (QueryException $e) {
						$this->_resumen['rechazados']++;
						$this->_error['lote']       = $lote;
						$this->_error['registro']   = json_encode($tablero_raw);
						$this->_error['created_at'] = date("Y-m-d H:i:s");
						if ($e->getCode() == 23505) {
							$this->_error['motivos'] = '{"pkey" : ["Registro ya informado"]}';
						} else if ($e->getCode() == 22021 || $e->getCode() == '22P05') {
							$this->_error['registro'] = json_encode(parent::vaciarArray($tablero_raw));
							$this->_error['motivos']  = json_encode(array('code' => $e->getCode(), 'linea' => $nro_linea, 'error' => 'El formato de caracteres es inválido para la codificación UTF-8. No se pudo convertir. Intente convertir esas lineas a UTF-8 y vuelva a procesarlas.'));
						} else {
							$this->_error['motivos'] = json_encode(array('code' => $e->getCode(), 'error' => $e->getMessage()));
						}
						Rechazo::insert($this->_error);
					}
				}
			} elseif (count($linea) == 1 && $linea[0] == '') {
				$this->_error['registro'] = json_encode($linea);
				$this->_error['motivos']  = '{"registro invalido" : ["Linea en blanco"]}';
				Rechazo::insert($this->_error);
			} else {
				$this->_resumen['rechazados']++;
				$this->_error['registro'] = json_encode($linea);
				$this->_error['motivos']  = json_encode('La cantidad de columnas ingresadas en la fila no es correcta');
				Rechazo::insert($this->_error);
			}
		}
		$this->actualizaLote($lote, $this->_resumen);
		$this->actualizaSubida($id);
		return response()->json(array('success' => 'true', 'data' => $this->_resumen));
	}

	public function procesarArchivoPgLoader($id_subida) {
		$fh = $this->abrirArchivo($id_subida);

		if (!$fh) {
			return response()->json(['success' => 'false', 'errors' => "El archivo no ha podido procesarse"]);
		}

		$lote = Lote::where('id_subida', $id_subida)->first()->lote;

		$nro_linea = 1;

		$info = Subida::findOrFail($id_subida);

		$this->_process_data['FILE_PATH']   = $this->_process_data['FILE_DIR'].$info->nombre_actual;
		$this->_process_data['NUMBER_LOTE'] = $lote;

		$unique_file = uniqid().".load";

		try {
			system("sudo cp ".$this->_process_data['LOGIC_DIR'].$this->_process_data['LOGIC_FILE_NAME']." ".$this->_process_data['LOGIC_DIR'].$unique_file);

			system("sed -i 's|:FILE_PATH|'".$this->_process_data['FILE_PATH']."'|g; s/:TABLE_NAME/".$this->_process_data['TABLE_NAME']."/g; s/:NUMBER_LOTE/".$this->_process_data['NUMBER_LOTE']."/g' ".$this->_process_data['LOGIC_DIR'].$unique_file);

			$complete_result_file = $this->_process_data['LOGIC_DIR'].$unique_file.'.result';

			//EJECUTO pgloader enviando los resultados a un archivo
			MyShellException::execute("sudo pgloader ".$this->_process_data['LOGIC_DIR'].$unique_file.' > '.$complete_result_file);

			//PASS errores to a variable
			exec('grep -A 1 "ERROR" '.$complete_result_file, $errors);

			//Getting last line of result
			exec('tail -1 '.$complete_result_file, $result);
			//Skipping mistakes in result
			$result = array_values($result);
			$result = array_pop($result);

			//Transforming line into an array
			preg_match("/(?:Total\ import\ time)(?:\ +)(\d+)(?:\ +)(\d+)(?:\ +)(\d+)(?:\ +)(\d+\.\d+s)/", $result, $procesado);

			Log::info("PROCESO TABLERO PGLOADER", array("type" => "server_process", "RESULTADO" => $result));
			Log::info("PROCESO TABLERO PGLOADER", array("type" => "server_process", "PROCESADO" => $procesado));

			$this->_resumen['insertados'] = $procesado[2];
			$this->_resumen['rechazados'] = $procesado[3];
			system("sudo rm ".$this->_process_data['LOGIC_DIR'].$unique_file);
			system("sudo rm ".$complete_result_file);
		} catch (MyShellException $e) {
			$this->_error['lote']       = $lote;
			$this->_error['created_at'] = date("Y-m-d H:i:s");
			$this->_error['registro']   = json_encode("PgLoader Error");
			$this->_error['motivos']    = json_encode($e->getMessage());
			Rechazo::insert($this->_error);
		} catch (\Exception $e) {
			$this->_error['lote']       = $lote;
			$this->_error['created_at'] = date("Y-m-d H:i:s");
			$this->_error['registro']   = json_encode("PgLoader Error");
			$this->_error['motivos']    = json_encode($e->getMessage());
			Rechazo::insert($this->_error);
		}

		if (!empty($errors)) {
			$this->_error['lote']       = $lote;
			$this->_error['created_at'] = date("Y-m-d H:i:s");
			$this->_error['registro']   = json_encode("PgLoader Error");
			$this->_error['motivos']    = json_encode($errors);
			Rechazo::insert($this->_error);
		}

		$this->actualizaLote($lote, $this->_resumen);
		$this->actualizaSubida($id_subida);
		return response()->json(array('success' => 'true', 'data' => $this->_resumen));
	}

	/**
	 * Crea un nuevo lote
	 * @param int $id_subida
	 *
	 * @return int
	 */
	protected function nuevoLote($id_subida) {
		$l                = new Lote;
		$l->id_subida     = $id_subida;
		$l->id_usuario    = Auth::user()->id_usuario;
		$l->id_provincia  = Auth::user()->id_provincia;
		$l->registros_in  = 0;
		$l->registros_out = 0;
		$l->registros_mod = 0;
		$l->id_estado     = 1;
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
	protected function actualizaLote($lote, $resumen) {
		$l                = Lote::findOrFail($lote);
		$l->registros_in  = $resumen['insertados'];
		$l->registros_out = $resumen['rechazados'];
		$l->registros_mod = $resumen['modificados'];
		$l->fin           = 'now';
		$l->save();
		/*
	$a       = new Request();
	$a->lote = $lote;

	$this->aceptarLote($a);
	 */
	}

	/**
	 * Actualiza el archivo con los datos procesados
	 * @param int $id
	 *
	 * @return bool
	 */
	protected function actualizaSubida($subida) {
		$s            = Subida::findOrFail($subida);
		$s->id_estado = 3;
		return $s->save();
	}

	/**
	 * Rechazar indicadores del periodo
	 * @param object $r
	 *
	 * @return void
	 */
	public function rechazar(Request $r) {
		Administracion::where('periodo', $r->periodo)->where('provincia', $r->provincia)->where('estado', 3)->delete();
		$admin                 = new Administracion();
		$admin->periodo        = $r->periodo;
		$admin->provincia      = $r->provincia;
		$admin->estado         = 4;
		$admin->usuario_accion = Auth::user()->id_usuario;
		$admin->save();
		Ingreso::where('periodo', $r->periodo)->where('provincia', $r->provincia)->delete();
		return response()->json("OK");
	}

	/**
	 * Aceptar indicadores del periodo
	 * @param object $r
	 *
	 * @return void
	 */
	public function aceptar(Request $r) {

		if (Administracion::where('periodo', $r->periodo)->where('provincia', $r->provincia)->where('estado', 3)->count() > 0) {
			return 'Ya fueron aceptados los indicadores de la provincia en el periodo';
		}

		$admin                 = new Administracion();
		$admin->periodo        = $r->periodo;
		$admin->provincia      = $r->provincia;
		$admin->estado         = 3;
		$admin->usuario_accion = Auth::user()->id_usuario;
		$admin->save();
		return response()->json("OK");
	}

	/**
	 * Aceptar periodo
	 * @param object $r
	 *
	 * @return void
	 */
	public function aceptarPeriodo(Request $r) {
		return $this->aceptar($this->newIngresoRequest($r->id_ingreso));
	}

	/**
	 * Rechazar periodo
	 * @param object $r
	 *
	 * @return void
	 */
	public function rechazarPeriodo(Request $r) {
		return $this->rechazar($this->newIngresoRequest($r->id_ingreso));
	}

	/**
	 * Aceptar periodo
	 * @param object $r
	 *
	 * @return void
	 */
	public function newIngresoRequest($id_ingreso) {

		$ingreso = Ingreso::find($id_ingreso);

		$a            = new Request();
		$a->periodo   = $ingreso->periodo;
		$a->provincia = $ingreso->provincia;

		return $a;
	}

	/**
	 * Administrar periodos cargados
	 * @param object $r
	 *
	 * @return view
	 */
	public function administracion($periodo = null, $provincia = null) {
		$data = [
			'page_title' => 'Administrar periodo',
			'periodo'    => date('Y-m', strtotime("now")),
			'user'       => Auth::user(),
			'provincias' => Provincia::all()
		];
		return view('tablero.administracion', $data);
	}

	/**
	 * Devuelve los datos de administracion
	 * @param variables $r
	 *
	 * @return array
	 */
	public function datosAdministracionTabla($provincia, $periodo = null) {

		$arrayreturns = [];
		try {
			$results = Ingreso::select('tablero.ingresos.id as id_ingreso', DB::raw('NULL as id_estado'), 'tablero.ingresos.periodo as ingresos_periodo', 'tablero.ingresos.provincia as ingresos_provincia', DB::raw('public.clean_errors(geo.provincias.descripcion) as provincia_descripcion'), 'indicador', DB::raw('NULL as usuario_accion'), DB::raw('NULL as usuario_nombre'))
				->leftjoin('geo.provincias', 'tablero.ingresos.provincia', '=', 'geo.provincias.id_provincia');

			$rechazados = Administracion::select(DB::raw('NULL as id_ingreso'), 'estado as id_estado', 'periodo as ingresos_periodo', 'provincia as ingresos_provincia', DB::raw('public.clean_errors(geo.provincias.descripcion) as provincia_descripcion'), DB::raw('NULL as indicador'), 'usuario_accion', 'nombre as usuario_nombre')
				->leftjoin('geo.provincias', 'tablero.administracion.provincia', '=', 'geo.provincias.id_provincia')
				->leftjoin('sistema.usuarios', 'tablero.administracion.usuario_accion', '=', 'sistema.usuarios.id_usuario')
				->where('estado', '3');

			if ($provincia != 0) {
				$results->where('tablero.ingresos.provincia', $provincia);
				$rechazados->where('provincia', $provincia);
			}
			if ($periodo != '9999-99') {
				$results->where('tablero.ingresos.periodo', $periodo);
				$rechazados->where('periodo', $periodo);
			}

			$results->unionAll($rechazados);

			$results->orderBy(DB::raw('3'), 'desc')
			        ->orderBy(DB::raw('4'), 'asc');

			$results->get()->each(function ($item, $key) use (&$arrayreturns) {
					$arrayreturns[$item['ingresos_periodo']][$item['ingresos_provincia']]['usuario_nombre'] = $item['usuario_nombre'];
					$arrayreturns[$item['ingresos_periodo']][$item['ingresos_provincia']]['provincia_descripcion'] = $item['provincia_descripcion'];
					$arrayreturns[$item['ingresos_periodo']][$item['ingresos_provincia']]['id_estado'] = $item['id_estado'];
					$arrayreturns[$item['ingresos_periodo']][$item['ingresos_provincia']]['id_ingreso'] = $item['id_ingreso'];
					if ($item['usuario_accion'] == NULL) {
						$arrayreturns[$item['ingresos_periodo']][$item['ingresos_provincia']]['indicadores'][] = $item['indicador'];
						$arrayreturns[$item['ingresos_periodo']][$item['ingresos_provincia']]['estado'] = 'PENDIENTE';
					} else {
						$arrayreturns[$item['ingresos_periodo']][$item['ingresos_provincia']]['estado'] = 'ACEPTADO';
					}
				});

			$arrayreturns = $this->prepareArray($arrayreturns);

		} catch (\Exception $e) {
			logger($e->getErrors());
		}

		return $arrayreturns;
	}

	/**
	 * Arma el datatable de administracion
	 * @param vairables $r
	 *
	 * @return view
	 */
	public function listadoAdministracionTabla($provincia, $periodo = null) {

		$arrayreturns = $this->datosAdministracionTabla($provincia, $periodo);

		return Datatables::of(collect($arrayreturns))
			->addColumn(
			'action',
			function ($arrayreturn) {

				$arrayreturn = (object) $arrayreturn;
				$botones = '';

				if ($arrayreturn->id_estado == 3) {
					$botones = ' <button id_ingreso="'.$arrayreturn->id_ingreso.'" id="rechazar-periodo" class="btn btn-danger btn-xs"> RECHAZAR</button> ';
				} else if ($arrayreturn->id_estado == NULL && $arrayreturn->completado == 17) {
					$botones = ' <button id_ingreso="'.$arrayreturn->id_ingreso.'" id="aceptar-periodo" class="btn btn-success btn-xs"> ACEPTAR</button> <button id_ingreso="'.$arrayreturn->id_ingreso.'" id="rechazar-periodo" class="btn btn-danger btn-xs"> RECHAZAR</button> ';
				} else {
					$botones = ' <button class="btn btn-default btn-xs"> SIN ACCIONES</button> ';
				}

				return $botones;
			}
		)
			->make(true);
	}

	/**
	 * Arma el excel de administracion
	 * @param variables $r
	 *
	 * @return excel
	 */
	public function excelAdministracionTabla($provincia, $periodo = null) {

		$arrayreturns = $this->datosAdministracionTabla($provincia, $periodo);
		$data         = ['tablero' => collect($arrayreturns)];
		$name         = 'Administracion - Tablero de Control SUMAR';
		if ($provincia != 0) {$name .= ' - '.$provincia;
		}
		if ($periodo != '9999-99') {$name .= ' - '.$periodo;
		} else {
			$name .= ' al '.date('Y-m-d');
		}

		Excel::create($name, function ($e) use ($data) {
				$e->sheet('Administracion_SUMAR', function ($s) use ($data) {
						$s->loadView('tablero.tabla_administracion', $data);
						$s->setColumnFormat(array('A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@'));
					});
			})
			->export('xls');
	}

	/**
	 * Administrar periodos rechazados
	 * @param object $r
	 *
	 * @return view
	 */
	public function rechazados() {
		$data = [
			'page_title' => 'Historial de rechazos',
			'user'       => Auth::user(),
			'provincia'  => Provincia::find(Auth::user()->id_provincia)
		];
		return view('tablero.rechazados', $data);
	}

	/**
	 * Arma el datatable de administracion
	 * @param vairables $r
	 *
	 * @return view
	 */
	public function listadoRechazadosTabla() {

		$results = $this->datosRechazadosTabla();

		return Datatables::of($results)
			->make(true);
	}

	/**
	 * Arma el excel de rechazados
	 * @param variables $r
	 *
	 * @return excel
	 */
	public function excelRechazadosTabla() {

		$results = $this->datosRechazadosTabla();
		$data    = ['tablero' => $results->get(), 'id_entidad' => Auth::user()->id_entidad];
		$name    = 'Rechazados - Tablero de Control SUMAR';

		Excel::create("Rechazos - ".date('Y-m-d'), function ($e) use ($data) {
				$e->sheet('Rechazados_SUMAR', function ($s) use ($data) {
						$s->loadView('tablero.tabla_rechazados', $data);
						$s->setColumnFormat(array('A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@'));
					});
			})
			->export('xls');
	}

	/**
	 * Devuelve los datos de rechazados
	 * @param variables $r
	 *
	 * @return array
	 */
	public function datosRechazadosTabla() {

		$results = Administracion::select('id', 'periodo', DB::raw('public.clean_errors(geo.provincias.descripcion) as provincia_descripcion'), DB::raw('\'RECHAZADO\' as estado'), 'sistema.usuarios.nombre', DB::raw('tablero.administracion.updated_at::date as fecha'))
			->leftjoin('geo.provincias', 'tablero.administracion.provincia', '=', 'geo.provincias.id_provincia')
			->leftjoin('sistema.usuarios', 'tablero.administracion.usuario_accion', '=', 'sistema.usuarios.id_usuario')
			->where('estado', '4');

		if (Auth::user()->id_entidad != 1) {
			$results->where('provincia', Auth::user()->id_provincia);
		}

		$results->orderBy('fecha', 'desc');

		return $results;
	}

	/**
	 * Arma el array a mostrar en la datatable
	 * @param object $r
	 *
	 * @return array
	 */
	public function prepareArray($fullarray) {

		$returned_array = [];

		foreach ($fullarray as $field  => $value) {
			foreach ($value as $provincia => $datos) {
				if ($datos['estado'] == 'PENDIENTE') {
					(count($datos['indicadores']) == 17?($datos['estado'] = 'COMPLETADO SIN ACEPTAR') && ($datos['completado'] = 17):$datos['completado'] = count($datos['indicadores']));
				} else {
					$datos['completado'] = 17;
				}
				unset($datos['indicadores']);
				$returned_array[] = array_merge(array('periodo' => $field, 'provincia' => $provincia), $datos);
			}
		}

		return $returned_array;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getSelectGraficosTablero() {
		$data = [
			'page_title'   => 'Seleccione el periodo a visualizar',
			'id_provincia' => Auth::user()->id_provincia,
			'provincias'   => Provincia::all(),
			'indicadores'  => Detail::where('indicador', 'NOT LIKE', '%.%')->get()
		];
		return view('tablero.select-periodo-graficos', $data);
	}

	/**
	 * Devuelve la vista de los indicadores
	 * @param string $id
	 *
	 * @return null
	 */
	public function getGraficoTablero($periodo, $id_provincia, $sigla_indicador) {

		$indicador = $this->datosListadoTabla($periodo, $id_provincia);
		$indicador->where(DB::raw('left(indicador,1)'), $sigla_indicador);
		$collection = collect($indicador->get());

		$tipo_indicador = Detail::find($sigla_indicador);

		$collection->transform(function ($item, $key) {
				$item->detail = $this->getDetails($item->indicador);
				return $item;
			});

		$i = 0;
		foreach ($collection as $field => $item) {
			$indicadorActual[$i]['indicador']      = $item->indicador;
			$indicadorActual[$i]['detalles']       = Detail::find(strtr($item->indicador, array("|" => ".")));
			$result                                = $this->checkState($item->id);
			$indicadorActual[$i]['resultadoTotal'] = $result['value'];
			$indicadorActual[$i]['color']          = ($result['color'] == 'success')?'green':($result['color'] == 'warning'?'yellow':'red');
			$i++;
		}
		unset($i);

		$provincia = Provincia::find($id_provincia);

		$grafico = $this->getGraficoEvolucion($periodo, $id_provincia, $sigla_indicador);

		$data = [
			'page_title'     => 'Indicadores Tablero: '.$provincia->descripcion.' periodo: '.$periodo,
			'indicadores'    => $indicadorActual,
			'back'           => 'select-graficos-tablero',
			'id_provincia'   => $id_provincia,
			'provincia'      => $provincia,
			'periodo'        => $periodo,
			'grafico'        => $grafico,
			'tipo_indicador' => $tipo_indicador
		];

		return view('tablero.grafico_tablero', $data);

	}

	/**
	 * Devuelve los datos para los highcharts de evolucion
	 * @param string $id
	 * @param string $periodo
	 *
	 * @return array
	 */
	public function getGraficoEvolucion($periodo, $provincia, $sigla_indicador) {

		$indicador = $this->datosListadoTabla($periodo, $provincia);
		$indicador->where(DB::raw('left(indicador,1)'), $sigla_indicador);
		$indicador = $indicador->get();
		$i         = 0;

		if (!empty($indicador)) {
			foreach ($indicador as $field => $item) {

				$grafico[$i]['indicador'] = $item->indicador;
				//DEBO CALCULAR RANGOS $grafico[$i]['rangos']     = $item['rangoIndicador'];
				$grafico[$i]['resultados'] = $this->getUltimosIndicadores($item);
				$grafico[$i]['rangos']     = $this->getRangos($item);
				$grafico[$i]['categories'] = array();
				$grafico[$i]['data']       = array();

				foreach ($grafico[$i]['resultados'] as $item) {
					$dt     = \DateTime::createFromFormat('Y-m', $item['periodo']);
					$period = date('m/y', strtotime($dt->format('Y-m')));
					array_unshift($grafico[$i]['categories'], $period);
					array_unshift($grafico[$i]['data'], $item['resultado']);
				}
				$i++;
			}
			return $grafico;
		}
		return null;
	}

	/**
	 * Devuelve el resultado del indicador en los ultimos periodos
	 *
	 * @param  integer  $id
	 * @return array[float]
	 */
	public function getUltimosIndicadores($id) {

		$periodos = $this->getDateInterval6Months($id->periodo);

		$rows = Ingreso::whereIn('periodo', array_values($periodos))
			->where(DB::raw("replace(indicador,'.','|')"), $id->indicador)
			->where('provincia', $id->provincia)
			->orderBy('periodo', 'desc')
			->get();

		$i = 0;
		foreach ($rows as $field => $one) {
			$grafico[$i]['periodo']   = $one->periodo;
			$grafico[$i]['resultado'] = $this->checkStateValue($one);
			$i++;
		}

		return $grafico;
	}

	protected function getDateInterval6Months($periodo) {

		$dt         = \DateTime::createFromFormat('Y-m', $periodo);
		$interval[] = $dt->format('Y-m');

		for ($i = 0; $i < 6; $i++) {
			$dt->modify('-1 month');
			$interval[] = $dt->format('Y-m');
		}
		return $interval;
	}

	protected function getDetails($indicador) {
		return Detail::find($indicador);
	}

	protected function getRangos($indicador) {
		$rangos = Rango::where(DB::raw("replace(indicador,'.','|')"), $indicador->indicador)
		                                                                        ->where('year', intval(substr($indicador->periodo, 0, 4)))
			->where('id_provincia', $indicador->provincia)->first();

		$red = 100;
		foreach (json_decode($rangos->red) as $key => $value) {
			if (isset($value->multiple_condicion_1)) {
				foreach ($value as $clave => $valor) {
					foreach ($valor as $k2   => $v2) {
						Log::info($v2->valor);
						if ($red > $v2->valor) {
							$red = $v2->valor;
						}
					}
				}
			} else {
				Log::info($value->valor);
				if ($red > $value->valor) {
					$red = $value->valor;
				}
			}
		}
		$yellow = 100;
		foreach (json_decode($rangos->yellow) as $key => $value) {
			if (isset($value->multiple_condicion_1)) {
				foreach ($value as $clave => $valor) {
					foreach ($valor as $k2   => $v2) {
						Log::info($v2->valor);
						if ($yellow > $v2->valor) {
							$yellow = $v2->valor;
						}
					}
				}
			} else {
				Log::info($value->valor);
				if ($yellow > $value->valor) {
					$yellow = $value->valor;
				}
			}
		}
		$green = 100;
		foreach (json_decode($rangos->green) as $key => $value) {
			if (isset($value->multiple_condicion_1)) {
				foreach ($value as $clave => $valor) {
					foreach ($valor as $k2   => $v2) {
						Log::info($v2->valor);
						if ($green > $v2->valor) {
							$green = $v2->valor;
						}
					}
				}
			} else {
				Log::info($value->valor);
				if ($green > $value->valor) {
					$green = $value->valor;
				}
			}
		}

		return array('min_rojo' => $red, 'min_yellow' => $yellow, 'min_verde' => $green);
	}
}