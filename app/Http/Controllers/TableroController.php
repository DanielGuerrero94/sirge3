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
use App\Models\Tablero\LogAcciones;
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
		'periodo'   => 'El formato de fecha debe ser DD-MM-YYYY',
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
		$this->_user      = Auth::user();
		$this->_rules     = ['periodo' => 'required|date_format:d/m/Y|before:'.date('d-m-Y', strtotime('Dec 31')).'|after:2004-01-01',
			'provincia'                   => 'required|max:100',
			'indicador'                   => 'required|exists:tablero.descripcion,indicador',
			'numerador'                   => 'required_without:denominador|valor_tablero',
			'denominador'                 => 'required_without:numerador|valor_tablero',
			'lote'                        => 'required|integer'];
		$this->middleware('auth');
		$this->middleware('log.debug');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
        $user = Auth::user();
        $id_provincia = $user?$user->id_provincia:0;
		$data = [
			'page_title'   => 'Seleccione el periodo a visualizar',
			'id_provincia' => $id_provincia,
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
		if (Ingreso::join('tablero.administracion', function ($join) {
					$join->on('tablero.administracion.periodo', '=', 'tablero.ingresos.periodo');
					$join->on('tablero.administracion.provincia', '=', 'tablero.ingresos.provincia');
				})
				->where('tablero.ingresos.provincia', $provincia)
			->where('tablero.ingresos.periodo', $periodo)
				->count() == 0) {
            $user = Auth::user();
            $id_menu = $user?$user->id_menu:0;
			if (!in_array($id_menu, [1, 2, 3, 5, 11, 12, 14, 16, 18])) {
				return 1;
			}
			if (Ingreso::where('periodo', $periodo)->where('provincia', $provincia)->count() == 0) {
				return 2;
			}
		}

		$indicators = Ingreso::select('id', 'periodo', 'provincia', DB::raw("replace(indicador,'.','|') as indicador"), 'numerador', 'denominador')->where('provincia', $provincia)->where('periodo', $periodo)->get()->toArray();

		$alertas = $this->checkRelations($indicators);

		$indicadores_full = $this->indicadoresFull($periodo, $provincia);

		$data = [
			'page_title'       => 'Ingresos: Tablero de Control',
			'periodo'          => $periodo,
			'provincia'        => $provincia,
			'alertas'          => $alertas,
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
			$array_intersect  = array_intersect($array_indicadores, $array_indicadores_cargados);
			$indicadores_full = ($array_indicadores == $array_intersect)?'true':'false';
		}

		if ($indicadores_full == 'true' && Administracion::where('periodo', $periodo)
				->where('provincia', $provincia)->where('estado', 3)->count() > 0) {
			$indicadores_full = 'completed';
		}

		return $indicadores_full;
	}

	/**
	 * Busca el no cumplimiento de alguna relacion existente y devuelve un objeto alerta
	 *
	 * @return $alert
	 */
	public function checkRelations($indicators) {

		$alert = [];

		if ($this->valueFromArrayIndicatorB($indicators, "2|2") != ($this->valueFromArrayIndicatorB($indicators, "2|3")+$this->valueFromArrayIndicatorB($indicators, "2|4"))) {
			$alert["relation_2|2|b"] = "La relación del <b>denominador</b> en el indicador 2.2 no es la suma del 2.3 y 2.4";
		}
		if ($this->valueFromArrayIndicatorA($indicators, "2|2") != ($this->valueFromArrayIndicatorA($indicators, "2|3")+$this->valueFromArrayIndicatorA($indicators, "2|4"))) {
			$alert["relation_2|2|a"] = "La relación del <b>numerador</b> en el indicador 2.2 no es la suma del 2.3 y 2.4";
		}

		return $alert;
	}

	/**
	 * Devuelve el valor del indicador A
	 *
	 * @return Integer
	 */
	public function valueFromArrayIndicatorA($row, $indicator) {
		return $row[array_search($indicator, array_column($row, 'indicador'))]["numerador"];
	}

	/**
	 * Devuelve el valor del indicador B
	 *
	 * @return Integer
	 */
	public function valueFromArrayIndicatorB($row, $indicator) {
		return $row[array_search($indicator, array_column($row, 'indicador'))]["denominador"];
	}

	/**
	 * Muestra el formulario de modificacion del indicador.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getModificar($id) {
		$indicador = Ingreso::find($id);

		$_rules_indicadores = ['1|1' => 'both',
			'1|2'                       => 'both',
			'2|1'                       => 'both',
			'2|2'                       => 'denominador',
			'2|3'                       => 'denominador',
			'2|4'                       => 'denominador',
			'5|2'                       => 'both',
			'5|4'                       => 'denominador'];

		$data = [
			'page_title'        => 'Modificacion del indicador',
			'ruta_back'         => 'main-tablero/'.$indicador->periodo.'/'.$indicador->provincia,
			'provincias'        => Provincia::all(),
			'user'              => Auth::user(),
			'indicador'         => $indicador,
			'rules_indicadores' => $_rules_indicadores];

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
			$estado_anterior          = array("numerador" => $unIndicador->numerador, "denominador" => $unIndicador->denominador);
			$unIndicador->numerador   = str_replace(array(","), ".", str_replace(array("$", "."), "", $r->numerador));
			$unIndicador->denominador = str_replace(array(","), ".", str_replace(array("$", "."), "", $r->denominador));
			$unIndicador->save();
		} catch (\Exception $e) {
			return json_encode(["resultado" => 'Ha ocurrido un error']);
		}

		$log               = new LogAcciones();
		$log->id_provincia = $unIndicador->provincia;
		$log->id_usuario   = Auth::user()->id_usuario;
		$log->accion       = json_encode(array("accion" => "Modificacion del Numerador o Denominador del indicador", "indicador" => $unIndicador->indicador, "periodo" => $unIndicador->periodo, "estado_anterior" => $estado_anterior, "estado_actual" => array("numerador" => str_replace(array(","), ".", str_replace(array("$", "."), "", $r->numerador)), "denominador" => str_replace(array(","), ".", str_replace(array("$", "."), "", $r->denominador)))));
		$log->save();

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
					return (empty($result->numerador) && !is_numeric($result->numerador))?null:($result->numerador);
				} else if (in_array($result->indicador, ['1|1', '1|2', '2|1', '2|2', '2|3', '2|4'])) {
					try {
						return (empty($result->numerador) && !is_numeric($result->numerador))?null:(number_format($result->numerador, 0, ',', '.'));
					} catch (\Exception $e) {
						return $result->numerador;
					}
				}
				try {
					return (empty($result->numerador) && !is_numeric($result->numerador))?null:('$ '.number_format($result->numerador, 0, ',', '.'));
				} catch (\Exception $e) {
					return $result->numerador;
				}

			}
		)
			->addColumn(
			'denominador_format',
			function ($result) {
				if (in_array($result->indicador, ['5|1', '5|3'])) {
					return (empty($result->denominador) && !is_numeric($result->denominador))?null:($result->denominador);
				} else if (in_array($result->indicador, ['1|1', '1|2', '2|1', '2|2', '2|3', '2|4', '5|4'])) {
					try {
						return (empty($result->denominador) && !is_numeric($result->denominador))?null:(number_format($result->denominador, 0, ',', '.'));
					} catch (\Exception $e) {
						return $result->denominador;
					}
				}
				try {
					return (empty($result->denominador) && !is_numeric($result->denominador))?null:('$ '.number_format($result->denominador, 0, ',', '.'));
				} catch (\Exception $e) {
					return $result->denominador;
				}

			}
		)
			->addColumn(
			'estado',
			function ($result) {
				$var_state = $this->checkState($result->id);
				if (!in_array($result->indicador, ['5|1', '5|3', '5|4', '5|5'])) {
					$var_state['value'] == 'INCOMPLETO'?$tipo_valor = "":$tipo_valor = " % ";
				} else {
					$tipo_valor = "";
				}
				return '<button class="btn btn-'.$var_state['color'].' btn-xs"> '.$var_state['value'].$tipo_valor.'</button>';
			}
		)
			->addColumn(
			'action',
			function ($result) {
                $indicadores_full = $this->indicadoresFull($result->periodo, $result->provincia);
                $id_menu = $this->_user->id_menu;
                $id_entidad = $this->_user->id_entidad;
                $observaciones = $result->observaciones;
                $id = $result->id;
				return $this->datatableActions($indicadores_full, $id_menu, $id_entidad, $observaciones, $id);
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

		$results = Ingreso::select('tablero.ingresos.id', 'tablero.ingresos.periodo', 'tablero.ingresos.provincia', DB::raw("replace(indicador,'.','|') as indicador"), 'numerador', 'denominador', 'observaciones')
			->with(['provincias']);

		if ($provincia != 99) {
			$results->where('tablero.ingresos.provincia', $provincia);
		}
		if ($periodo != '9999-99') {
			$results->where('tablero.ingresos.periodo', $periodo);
		}

		$results->orderBy('periodo', 'desc')
		        ->orderBy('provincia', 'asc')
		        ->orderBy(DB::raw('left(indicador,1)::integer'), 'asc')
		        ->orderBy(DB::raw('right(indicador,-2)::integer'), 'asc');

		return $results;
	}

	/**
	 * Arma el excel de ingresos
	 * @param variables $r
	 *
	 * @return excel
	 */
	public function excelListadoTabla($periodo, $provincia) {

		$data    = [];
		$results = $this->datosListadoTabla($periodo, $provincia);
		$results = collect($results->get());
		$results->transform(function ($item, $key) {
				$state = $this->checkState($item->id);
				$item->estado = $state['value'];
				$item->color = $state['color'];
				return $item;
			});

		$nombre_provincia = Provincia::find($provincia)->descripcion;
		if ($provincia == "01") {
			$nombre_provincia = "CABA";
		}

		$administracion = Administracion::where('periodo', $periodo)->where('provincia', $provincia)->first();

		$dt   = \DateTime::createFromFormat('Y-m', $periodo);
		$date = $dt->format('Y-m');
		$dt->modify('last day of this month');
		$last_day_period = $dt->format('d/m/Y');

		$data = ['tablero' => $results, 'id_entidad' => Auth::user()->id_entidad, 'periodo' => $periodo, 'nombre_provincia' => $nombre_provincia, 'usuario_aceptacion' => Usuario::find($administracion->usuario_accion)->nombre, 'fecha_aceptacion' => date_format($administracion->created_at, 'd/m/Y'), 'last_day_period' => $last_day_period];
		$name = 'Ingresos en $periodo - Tablero de Control SUMAR';

		$log               = new LogAcciones();
		$log->id_provincia = $provincia;
		$log->id_usuario   = Auth::user()->id_usuario;
		$log->accion       = json_encode(array("accion" => "Descarga de excel de indicadores cargados en periodo ".$periodo, "estado_anterior" => "No aplica", "estado_actual" => "No aplica"));
		$log->save();

		Excel::load('/var/www/html/sirge3/storage/uploads/tablero'.'/exported.xlsx', function ($reader) use ($data) {

				$s = $reader->sheet(0);
				$i = 6;//COMIENZO DE DATOS EN EXCEL
				setlocale(LC_MONETARY, 'it_AR');
				$s->setCellValue('D1', $data['nombre_provincia']);
				$s->setCellValue('G1', $data['periodo']);
				$s->setCellValue('A2', "TABLERO DE CONTROL GENERAL ACEPTADO EL ".$data['fecha_aceptacion']);
				foreach ($data['tablero'] as $row_fields) {
					$row_number = $this->returnExcelRow($row_fields['indicador']);
					$s->setCellValue('F'.strval($row_number), $row_fields['numerador']);
					$s->setCellValue('G'.strval($row_number), $row_fields['estado']);
					$s->setCellValue('F'.strval($row_number+1), $row_fields['denominador']);

					if ($row_fields['indicador'] == "5|5") {
						$saldo_inmovilizado_en_ugsp = $row_fields['numerador'];
						$s->setCellValue('D87', money_format('%.2n', $row_fields['numerador']));
					} elseif ($row_fields['indicador'] == "5|9") {
						$total_immovilizado_en_efectores = $row_fields['denominador']-$row_fields['numerador'];
						$denominador_5_9 = $row_fields['denominador'];
						$s->setCellValue('D88', money_format('%.2n', $total_immovilizado_en_efectores));
						//$s->setCellValue('D88', number_format(, 0, ',', '.'));
					} elseif ($row_fields['indicador'] == "5|8") {
						$denominador_5_8 = $row_fields['denominador'];
					} elseif ($row_fields['indicador'] == "5|4") {
						$benef_activos = $row_fields['denominador'];
					}
				}

				if (isset($saldo_inmovilizado_en_ugsp) && isset($total_immovilizado_en_efectores)) {
					$total_saldo_inmovilizado = $saldo_inmovilizado_en_ugsp+$total_immovilizado_en_efectores;
					$s->setCellValue('D89', money_format('%.2n', $total_saldo_inmovilizado));
					$s->setCellValue('E87', ($saldo_inmovilizado_en_ugsp/$denominador_5_8));
					$s->setCellValue('E88', ($total_immovilizado_en_efectores/$denominador_5_9));
					$s->setCellValue('E89', ($total_saldo_inmovilizado/$denominador_5_8));
					$s->setCellValue('F91', money_format('%.2n', $total_saldo_inmovilizado/$benef_activos));
				}
				$s->setCellValue('C86', "TOTAL SALDO INMOVILIZADO AL ".$data['last_day_period']);
			})->setFilename("T_".$nombre_provincia."_".$periodo)->export('xlsx');
	}

	/**
	 * Return row number
	 * @param string $indicador
	 *
	 * @return $row_number
	 */
	public function returnExcelRow($indicador) {

		switch ($indicador) {
			case '1|1':
				return 10;
				break;
			case '1|2':
				return 14;
				break;
			case '2|1':
				return 20;
				break;
			case '2|2':
				return 24;
				break;
			case '2|3':
				return 28;
				break;
			case '2|4':
				return 32;
				break;
			case '2|5':
				return 36;
				break;
			case '5|1':
				return 42;
				break;
			case '5|2':
				return 46;
				break;
			case '5|3':
				return 50;
				break;
			case '5|4':
				return 54;
				break;
			case '5|5':
				return 58;
				break;
			case '5|6':
				return 62;
				break;
			case '5|7':
				return 66;
				break;
			case '5|8':
				return 70;
				break;
			case '5|9':
				return 74;
				break;
			case '5|10':
				return 78;
				break;
			case '5|11':
				return 82;
				break;

			default:
				return 100;
				break;
		}
	}

	/**
	 * Return state color and fill background
	 * @param $state, $sheet
	 *
	 * @return $sheet
	 */
	public function returnExcelStateColor($state, $sheet, $row_number) {

		switch (true) {
			case ($state == 'success'):
				$sheet->cell('H'.strval($row_number), function ($color) {$color->setBackground("#82fa58");	});
				break;
			case ($state == 'warning'):
				$sheet->cell('I'.strval($row_number), function ($color2) {$color2->setBackground("#ffff00");	});
				break;
			case ($state == 'danger'):
				$sheet->cell('J'.strval($row_number), function ($color3) {$color3->setBackground("#b40404");	});
				break;

			default:
				break;
		}
	}

	/**
	 * Arma el excel de ingresos
	 * @param variables $r
	 *
	 * @return excel
	 */
	public function excelListadoTablaOriginal($periodo, $provincia) {

		$results = $this->datosListadoTabla($periodo, $provincia);
		$results = collect($results->get());
		$results->transform(function ($item, $key) {
				$state = $this->checkState($item->id);
				$item->estado = $state['value'];
				$item->color = $state['color'];
				$item->indicador = strtr($item->indicador, array("|" => "."));
				return $item;
			});

		$data = ['tablero' => $results, 'id_entidad' => Auth::user()->id_entidad, 'periodo' => $periodo];
		$name = 'Ingresos en $periodo - Tablero de Control SUMAR';

		$log               = new LogAcciones();
		$log->id_provincia = $provincia;
		$log->id_usuario   = Auth::user()->id_usuario;
		$log->accion       = json_encode(array("accion" => "Descarga de excel de indicadores cargados en periodo ".$periodo, "estado_anterior" => "No aplica", "estado_actual" => "No aplica"));
		$log->save();

		Excel::create("Indicadores_".$provincia."_".date('Y-m-d'), function ($e) use ($data) {
				$e->sheet('Ingresos_SUMAR', function ($s) use ($data) {
						$s->loadView('tablero.tabla_ingresos', $data);
						$s->setColumnFormat(array('A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@'));
						$i = 6;//COMIENZO DE DATOS EN EXCEL
						foreach ($data['tablero'] as $row_fields) {

							$s->row($i, ['Col 6']);
							switch (true) {
								case ($row_fields['color'] == "success"):
									$color_background = '#00FF00';
									break;

								case ($row_fields['color'] == "warning"):
									$color_background = '#FFFF00';
									break;

								case ($row_fields['color'] == "danger"):
									$color_background = '#FF0000';
									break;

								default:
									$color_background = '#C0C0C0';
									break;
							}
							$s->cell('F'.$i, function ($color) use ($color_background) {$color->setBackground($color_background);});

							$i++;
						}
					});
			})
			->store('xls');

		return response()->download("../storage/exports/Indicadores_".$provincia."_".date('Y-m-d').".xls");

	}

	/**
	 * Devuelve el codigo HTML de los botones de accion de la datatable
	 *
	 * @return text (HTML)
	 */
	public function datatableActions($indicadores_full, $id_menu, $id_entidad, $observaciones, $id) {
        $botones = '';

		if (!in_array($indicadores_full, array('completed', 'rejected'))) {

			if (in_array($id_menu, array(12, 14, 3)) && $id_entidad == 2) {
				if (Ingreso::find($id)->blocked) {
					$botones = '<button id="'.$id.'" class="btn btn-default btn-xs" data-toggle="listado-tooltip" data-placement="top" title="El indicador fue bloqueado por la UEC" style="background-coĺor:#ccc; border-color:#e8e7e7; color:#b1aeae"><i class="fa fa-pencil-square-o"></i> Editar</button> ';
				} else {
					$botones = '<button id="'.$id.'" class="modificar-indicador btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Editar</button> ';
				}

				$botones .= '<button id="'.$id.'" class="observar-indicador btn bg-grey btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Ver observaciones"> <i class="fa fa-envelope-o"></i></button> ';
			} else if (in_array($id_menu, array(1, 2, 5, 11, 16, 18)) && $id_entidad == 1) {
				if (Ingreso::find($id)->blocked) {
					$botones = '<button id="'.$id.'" class="modificar-indicador btn btn-info btn-xs" disabled><i class="fa fa-pencil-square-o"></i> Editar</button> ';
					$botones .= '<button id="'.$id.'" class="observar-indicador btn bg-primary btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Detalle una observacion para alertar a la provincia"> <i class="fa fa-eye"></i>  OBSERVAR</button> ';
					$botones .= '<button id="'.$id.'" class="bloquear-indicador btn btn-success btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Desbloquear modificacion del indicador"> DESBLOQUEAR</button> ';
				} else {
					$botones = '<button id="'.$id.'" class="modificar-indicador btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Editar</button> ';
					$botones .= '<button id="'.$id.'" class="observar-indicador btn bg-primary btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Detalle una observacion para alertar a la provincia"> <i class="fa fa-eye"></i>  OBSERVAR</button> ';
					$botones .= '<button id="'.$id.'" class="bloquear-indicador btn btn-danger btn-xs" data-toggle="listado-tooltip" data-placement="top" title="Bloquear modificacion del indicador"> BLOQUEAR</button> ';
				}

				if (isset($observaciones)) {
					$botones .= ' <i class="fa fa-exclamation-circle" style="color:red" data-toggle="listado-tooltip" data-placement="top" title="Hay mensajes intercambiados"></i>';
				}
			} else if (in_array($id_menu, array(17, 15)) && $id_entidad == 1) {
				$botones = ' <button class="btn btn-default btn-xs">SIN PRIVILEGIOS</button> ';
			}

		} else {
			if ($indicadores_full == 'completed') {
				$botones = ' <button id="'.$id.'" class="btn btn-success btn-xs"> ACEPTADO</button> ';
			} else {
				$botones = ' <button id="'.$id.'" class="btn btn-danger btn-xs"> RECHAZADO</button> ';
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
			if (empty($id->numerador)) {
				return 0;
			} else {
				$datetime_denominador = DateTime::createFromFormat('d/m/Y', $id->denominador);
				$datetime_numerador   = DateTime::createFromFormat('d/m/Y', $id->numerador);
				$interval_diff        = $datetime_numerador->diff($datetime_denominador);
				$value                = $interval_diff->format('%a');
			}
			return (integer) $value;
		} elseif (in_array($indicador, ['5|4', '5|5'])) {
			return (($id->denominador != "" && $id->denominador != NULL && $id->denominador != " " && $id->denominador != "0") && ($id->numerador != "" && $id->numerador != NULL && $id->numerador != " " && $id->numerador != "0"))?round((float) $id->numerador/(float) $id->denominador, 2):'INCOMPLETO';
		} elseif (in_array($indicador, ['2|5'])) {
			return (($id->denominador != "" && $id->denominador != NULL && $id->denominador != " " && $id->denominador != "0") && ($id->numerador != "" && $id->numerador != NULL && $id->numerador != " " && $id->numerador != "0"))?round((float) $id->numerador/(float) $id->denominador*100, 2):0;
		} else {
			try {
				return (($id->denominador != "" && $id->denominador != NULL && $id->denominador != " ") && ($id->numerador != "" && $id->numerador != NULL && $id->numerador != " "))?round((float) $id->numerador/(float) $id->denominador*100, 2):'INCOMPLETO';
			} catch (\Exception $e) {
				return 0;
			}

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

		$data = [
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

				$array_responsables = array("01" => 292, "02" => 292, "03" => 386, "04" => 330, "05" => 291, "06" => 386, "07" => 330, "08" => 291, "09" => 330, "10" => 386, "11" => 330, "12" => 291, "13" => 292, "14" => 330, "15" => 386, "16" => 330, "17" => 291, "18" => 291, "19" => 386, "20" => 386, "21" => 330, "22" => 291, "23" => 291, "24" => 386);

				$cadena_uec = Usuario::where('id_entidad', 1)->whereIn('id_menu', [11, 16, 18])->where('id_usuario', $array_responsables[Auth::user()->id_provincia])->lists('email');

				Mail::send('emails.respuesta-observacion', ['user' => Auth::user(), 'indicador' => $indicador, 'mensaje' => $r->observacion], function ($m) use ($cadena_uec) {
						$m->from('sirgeweb@sumar.com.ar', 'SIRGe Web');
						foreach ($cadena_uec as $supervision_uec) {
							$m->to($supervision_uec);
						}
						$m->cc('syaecp@gmail.com');
						$m->bcc('javier.minsky@gmail.com');
						$m->subject('Respuesta a observacion en Tablero de Control!');
					});
			} else {
				$cadena_ugsp = Usuario::where('id_entidad', 2)->where('id_provincia', $indicador->provincia)->whereIn('id_menu', [12, 14, 16])->lists('email');

				Mail::send('emails.observacion', ['user' => Auth::user(), 'indicador' => $indicador, 'mensaje' => $r->observacion], function ($m) use ($cadena_ugsp) {
						$m->from('sirgeweb@sumar.com.ar', 'Sirge Web');
						foreach ($cadena_ugsp as $supervision_ugsp) {
							$m->to($supervision_ugsp);
						}
						$m->cc('syaecp@gmail.com');
						$m->bcc('javier.minsky@gmail.com');
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

		$fh   = $this->abrirArchivo($id);
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
			} elseif (count($linea) == 1 && $linea[0] == $lote) {
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

		$log               = new LogAcciones();
		$log->id_provincia = Auth::user()->id_provincia;
		$log->id_usuario   = Auth::user()->id_usuario;
		$log->accion       = json_encode(array("accion" => "Subida de archivo", "estado_anterior" => "No aplica", "estado_actual" => "No aplica"));
		$log->save();

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
		return response()->json(array("status" => "ok", "msj" => "Se ha rechazado el periodo para la provincia"));
	}

	/**
	 * Aceptar indicadores del periodo
	 * @param object $r
	 *
	 * @return void
	 */
	public function aceptar(Request $r) {

		if (Administracion::where('periodo', $r->periodo)->where('provincia', $r->provincia)->where('estado', 3)->count() > 0) {
			response()->json(array("status" => "error", "msj" => "Ya fueron aceptados los indicadores de la provincia en el periodo"));
		}

		$admin                 = new Administracion();
		$admin->periodo        = $r->periodo;
		$admin->provincia      = $r->provincia;
		$admin->estado         = 3;
		$admin->usuario_accion = Auth::user()->id_usuario;
		$admin->save();
		return response()->json(array("status" => "OK", "msj" => "Se ha ejecutado la accion correctamente"));
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

		$a = new \Illuminate\Http\Request();
		$a->setMethod('POST');
		$a->request->add(['periodo' => $ingreso->periodo, 'provincia' => $ingreso->provincia]);

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
			'provincias' => Provincia::all(),
			'provincia'  => $provincia
		];
		return view('tablero.administracion', $data);
	}

	/**
	 * Devuelve los datos de administracion
	 * @param variables $r
	 *
	 * @return array
	 */
	public function datosAdministracionTabla($provincia, $periodo) {

		$arrayreturns = [];
		$finalreturn  = [];
		try {

			$results = DB::table('tablero.ingresos as ing1')
				->selectRaw('NULL as id_estado, ing1.periodo as ingresos_periodo, ing1.provincia as ingresos_provincia, public.clean_errors(geo.provincias.descripcion) as provincia_descripcion, NULL as usuario_accion, NULL as usuario_nombre')
				->selectSub(function ($query) {

					/** @var $query \Illuminate\Database\Query\Builder */
					$query->from('tablero.ingresos as ing2')
						->selectRaw('array_to_json(array_agg(indicador))')
					->whereRaw('ing2.provincia = ing1.provincia')
						->whereRaw('ing2.periodo = ing1.periodo');
				}, 'indicadores')
				->selectSub(function ($query) {

					/** @var $query \Illuminate\Database\Query\Builder */
					$query->from('tablero.ingresos as ing3')
						->select('id')
					->whereRaw('ing3.provincia = ing1.provincia')
						->whereRaw('ing3.periodo = ing1.periodo')
					->take(1);
				}, 'id_ingreso')

				->leftjoin('geo.provincias', 'ing1.provincia', '=', 'geo.provincias.id_provincia')
				->groupBy(DB::raw('1'), DB::raw('2'), DB::raw('3'), DB::raw('4'));

			$rechazados = Administracion::selectRaw('estado as id_estado, periodo as ingresos_periodo, provincia as ingresos_provincia, public.clean_errors(geo.provincias.descripcion) as provincia_descripcion, usuario_accion, nombre as usuario_nombre, NULL as indicadores, NULL as id_ingreso')
				->leftjoin('geo.provincias', 'tablero.administracion.provincia', '=', 'geo.provincias.id_provincia')
				->leftjoin('sistema.usuarios', 'tablero.administracion.usuario_accion', '=', 'sistema.usuarios.id_usuario')
				->where('estado', '3');

			if ($provincia != '99') {
				$results->where('ing1.provincia', $provincia);
				$rechazados->where('provincia', $provincia);
			}
			if ($periodo != '9999-99') {
				$results->where('ing1.periodo', $periodo);
				$rechazados->where('periodo', $periodo);
			}

			$results->unionAll($rechazados);

			$results->orderBy(DB::raw('2'), 'desc')
			        ->orderBy(DB::raw('3'), 'asc')
			        ->orderBy(DB::raw('1'), 'asc');

			//Log::info($results->toSql());
			$results = $results->get();

			foreach ($results as $item) {

				//$var_provincia = substr_replace($item->ingresos_provincia, "_", 1, 0);

				$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['incompleto']            = false;
				$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['provincia_descripcion'] = $item->provincia_descripcion;
				$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['id_ingreso']            = $item->id_ingreso;
				$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['periodo']               = $item->ingresos_periodo;
				if ($item->usuario_accion != NULL) {
					$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['estado']         = 'ACEPTADO';
					$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['usuario_nombre'] = $item->usuario_nombre;
					$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['id_estado']      = $item->id_estado;
				} else {
					if (!isset($arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['id_estado'])) {
						$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['indicadores']    = json_decode($item->indicadores);
						$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['estado']         = 'PENDIENTE';
						$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['id_estado']      = NULL;
						$arrayreturns[$item->ingresos_periodo][$item->ingresos_provincia]['usuario_nombre'] = NULL;
					}
				}
			}

			$finalreturn = $this->prepareArray($arrayreturns);

		} catch (\Exception $e) {
			logger($e->getMessage());
		}

		return $finalreturn;
	}

	/**
	 * Arma el datatable de administracion
	 * @param vairables $r
	 *
	 * @return view
	 */
	public function listadoAdministracionTabla($provincia, $periodo) {

		$arrayreturns = $this->datosAdministracionTabla($provincia, $periodo);

		return Datatables::of(collect($arrayreturns))
			->addColumn(
			'action',
			function ($arrayreturn) {
				$arrayreturn = (object) $arrayreturn;

				$botones = '';

				if (isset($arrayreturn->id_estado)) {
					if ($arrayreturn->id_estado == 3) {
						$botones = ' <button id_ingreso="'.$arrayreturn->id_ingreso.'" id="rechazar-periodo" class="btn btn-danger btn-xs"> RECHAZAR</button> ';
					}
				} else if (!$arrayreturn->incompleto) {
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
	public function excelAdministracionTabla($provincia, $periodo) {

		$arrayreturns = $this->datosAdministracionTabla($provincia, $periodo);

		$data = ['tablero' => collect($arrayreturns)];
		$name = 'Administracion - Tablero de Control SUMAR';
		if ($provincia != '99') {$name .= ' - '.$provincia;
		}
		if ($periodo != '9999-99') {$name .= ' - '.$periodo;
		} else {
			$name .= ' al '.date('Y-m-d');
		}

		$log               = new LogAcciones();
		$log->id_provincia = Auth::user()->id_provincia;
		$log->id_usuario   = Auth::user()->id_usuario;
		$log->accion       = json_encode(array("accion" => "Descarga de excel de administracion en periodo ".$periodo." provincia ".$provincia, "estado_anterior" => "No aplica", "estado_actual" => "No aplica"));
		$log->save();

		return Excel::create($name, function ($e) use ($data) {
				$e->sheet('Administracion_SUMAR', function ($s) use ($data) {
						$s->loadView('tablero.tabla_administracion', $data);
						$s->setColumnFormat(array('A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@'));
					});
			})
			->download('xls');
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

		$log               = new LogAcciones();
		$log->id_provincia = Auth::user()->id_provincia;
		$log->id_usuario   = Auth::user()->id_usuario;
		$log->accion       = json_encode(array("accion" => "Descarga de excel de rechazos", "estado_anterior" => "No aplica", "estado_actual" => "No aplica"));
		$log->save();

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

		$results = Administracion::select('id', 'periodo', 'provincia', 'usuario_accion', DB::raw('\'RECHAZADO\' as estado'), DB::raw('tablero.administracion.updated_at::date as fecha'))
			->with(['provincias', 'usuario'])
			->where('estado', '4');

		if (Auth::user()->id_entidad != 1) {
			$results->where('provincia', Auth::user()->id_provincia);
		}

		$results->orderBy('updated_at', 'desc');

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

		foreach ($fullarray as $field => $value) {

			foreach ($value as $provincia => $data) {

				$datos               = $data;
				$indicadores_full    = false;
				$provincia_cp        = strval($provincia);
				$datos['incompleto'] = false;

				$year = substr($datos['periodo'], 0, 4);

				$datos['completado'] = count(array_values(explode(',', substr(YearIndicadores::find($year)->indicadores, 1, -1))));

				if ($datos['estado'] == 'PENDIENTE') {
					$indicadores_full = $this->checkCompletedPeriod($year, $datos['indicadores']);
				}

				if ($indicadores_full) {
					$datos['estado']     = 'COMPLETADO SIN ACEPTAR';
					$datos['completado'] = strval($datos['completado'])."/".strval($datos['completado']);
				} else {
					$datos['incompleto'] = true;
					if (isset($datos['indicadores'])) {
						$datos['completado'] = strval(count($datos['indicadores']))."/".strval($datos['completado']);
					} else {
						$datos['completado'] = strval($datos['completado'])."/".strval($datos['completado']);
					}
				}

				$datos['periodo']   = strval($field);
				$datos['provincia'] = $provincia_cp;

				$returned_array[] = $datos;
			}
		}

		return $returned_array;
	}

	/**
	 * Arma el array a mostrar en la datatable
	 * @param object $r
	 *
	 * @return array
	 */
	public function checkCompletedPeriod($year, $indicators) {

		/**
		 * Check if Tablero is completed on period.
		 *
		 * @return Boolean
		 */

		$indicadores = array_values(explode(',', substr(YearIndicadores::find($year)->indicadores, 1, -1)));
		sort($indicadores);
		sort($indicators);
		return count(array_intersect($indicadores, $indicators)) == count($indicadores);

	}

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
	public function getGraficoTablero($periodo_desde, $periodo_hasta, $id_provincia, $sigla_indicador) {

		if (Administracion::where('provincia', $id_provincia)->where('periodo', $periodo_hasta)->where('estado', 3)->count() == 0) {
			return 0;
		}

		$indicador = $this->datosListadoTabla($periodo_hasta, $id_provincia);
		$indicador->join('tablero.administracion', function ($join) {
				$join->on('tablero.administracion.periodo', '=', 'tablero.ingresos.periodo');
				$join->on('tablero.administracion.provincia', '=', 'tablero.ingresos.provincia');
			})
			->where('tablero.administracion.estado', 3);
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

		$grafico = $this->getGraficoEvolucion($periodo_desde, $periodo_hasta, $id_provincia, $sigla_indicador);

		$data = [
			'page_title'     => 'Indicadores Tablero: '.$provincia->descripcion.' hasta periodo: '.$periodo_hasta,
			'indicadores'    => $indicadorActual,
			'back'           => 'select-graficos-tablero',
			'id_provincia'   => $id_provincia,
			'provincia'      => $provincia,
			'periodo'        => $periodo_hasta,
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
	public function getGraficoEvolucion($periodo_desde, $periodo_hasta, $provincia, $sigla_indicador) {

		$indicador = $this->datosListadoTabla($periodo_hasta, $provincia);
		$indicador->join('tablero.administracion', function ($join) {
				$join->on('tablero.administracion.periodo', '=', 'tablero.ingresos.periodo');
				$join->on('tablero.administracion.provincia', '=', 'tablero.ingresos.provincia');
			})
			->where('tablero.administracion.estado', 3)
			->whereIn('tablero.administracion.periodo', $this->getDateIntervalBetween($periodo_desde, $periodo_hasta));

		$indicador->where(DB::raw('left(indicador,1)'), $sigla_indicador);
		$indicador = $indicador->get();

		$i = 0;

		if (!empty($indicador)) {
			foreach ($indicador as $field => $item) {

				$grafico[$i]['indicador'] = $item->indicador;
				//DEBO CALCULAR RANGOS $grafico[$i]['rangos']     = $item['rangoIndicador'];
				$grafico[$i]['resultados'] = $this->getUltimosIndicadores($item, $periodo_desde);
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
	public function getUltimosIndicadores($id, $periodo_desde = null) {

		if ($periodo_desde) {
			$periodos = $this->getDateIntervalBetween($periodo_desde, $id->periodo);
		} else {
			$periodos = $this->getDateInterval6Months($id->periodo);
		}

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
			$dt->modify('first day of last month');
			$interval[] = $dt->format('Y-m');
		}
		return $interval;
	}

	protected function getDateIntervalBetween($periodo_desde, $periodo_hasta) {

		$dt         = \DateTime::createFromFormat('Y-m', $periodo_hasta);
		$dt_desde   = \DateTime::createFromFormat('Y-m', $periodo_desde);
		$month_diff = $dt->diff($dt_desde)->m;
		$interval[] = $dt->format('Y-m');

		for ($i = 0; $i < $month_diff; $i++) {
			$dt->modify('first day of last month');
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
						if ($red > $v2->valor) {
							$red = $v2->valor;
						}
					}
				}
			} else {
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
						if ($yellow > $v2->valor) {
							$yellow = $v2->valor;
						}
					}
				}
			} else {
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
						if ($green > $v2->valor) {
							$green = $v2->valor;
						}
					}
				}
			} else {
				if ($green > $value->valor) {
					$green = $value->valor;
				}
			}
		}

		return array('min_rojo' => $red, 'min_yellow' => $yellow, 'min_verde' => $green);
	}

	/**
	 * Muestra el formulario de modificacion del indicador.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getLogAcciones() {
		$data = [
			'page_title' => 'Historial de acciones',
			'provincias' => Provincia::all(),
			'user'       => Auth::user()
		];

		return view('tablero.log_acciones', $data);
	}

	/**
	 * Muestra el listado de todas la acciones realizadas ordenado desde la más reciente.
	 * @param void
	 *
	 * @return datatable
	 */
	public function listadoAcciones() {

		$acciones = LogAcciones::with(['provincias', 'usuario'])->orderBy('id', 'desc')->get();
		return Datatables::of(collect($acciones))->make(true);
	}

	/**
	 * Bloquea la modificación de un indicador.
	 * @param $id
	 *
	 * @return datatable
	 */
	public function blockIndicator($id) {

		try {
			$indicator          = Ingreso::find($id);
			$indicator->blocked = TRUE;
			$indicator->save();
			return 1;
		} catch (Exception $e) {
			return 0;
		}
	}

	/**
	 * Desbloquea la modificación de un indicador.
	 * @param $id
	 *
	 * @return datatable
	 */
	public function unlockIndicator($id) {

		try {
			$indicator          = Ingreso::find($id);
			$indicator->blocked = FALSE;
			$indicator->save();
			return 1;
		} catch (Exception $e) {
			return 0;
		}
	}

	/**
	 * Display historical filters
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function mainHistorico($periodo_desde = null, $periodo_hasta = null, $provincia = null, $indicador = null) {
		$data = [
			'page_title'         => 'Seleccione provincia, periodo e indicador a descargar',
			'provincias'         => Provincia::all(),
			'indicadores'        => Detail::select(DB::raw("replace(indicador,'.','|') as indicador"))->where('indicador', 'LIKE', '%.%')->get(),
			'back_periodo_desde' => $periodo_desde,
			'back_periodo_hasta' => $periodo_hasta,
			'back_provincia'     => $provincia,
			'back_indicador'     => $indicador
		];

		return view('tablero.select-periodo-indicador', $data);
	}

	/**
	 * Display historical filters
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function listadoHistoricoView($periodo_desde, $periodo_hasta, $provincia, $indicador) {
		$data = [
			'page_title'    => 'Listado completo de indicadores para los filtros elegidos',
			'periodo_desde' => $periodo_desde,
			'periodo_hasta' => $periodo_hasta,
			'provincia'     => $provincia,
			'indicador'     => $indicador
		];

		return view('tablero.listado-historico', $data);
	}

	/**
	 * Filter by indicator
	 *
	 * @return Eloquent Object
	 */
	public function datosExtraHistorico($results, $indicador, $periodo_desde, $periodo_hasta) {

		if (strval($indicador) != "999") {
			$results->where('indicador', str_replace("|", ".", $indicador));
		}

		$results->whereBetween('tablero.administracion.periodo', array($periodo_desde, $periodo_hasta));

		$results->join('tablero.administracion', function ($join) {
				$join->on('tablero.administracion.periodo', '=', 'tablero.ingresos.periodo');
				$join->on('tablero.administracion.provincia', '=', 'tablero.ingresos.provincia');
			})->where('tablero.administracion.estado', 3);

		return $results;
	}

	/**
	 * Devuelve un json para la datatable
	 *
	 * @return json
	 */
	public function listadoHistoricoTable($periodo_desde, $periodo_hasta, $provincia, $indicador) {

		$results = $this->datosListadoTabla('9999-99', $provincia);

		$this->datosExtraHistorico($results, $indicador, $periodo_desde, $periodo_hasta);

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
					return (empty($result->numerador) && !is_numeric($result->numerador))?null:($result->numerador);
				} else if (in_array($result->indicador, ['1|1', '1|2', '2|1', '2|2', '2|3', '2|4'])) {
					try {
						return (empty($result->numerador) && !is_numeric($result->numerador))?null:(number_format($result->numerador, 0, ',', '.'));
					} catch (\Exception $e) {
						return $result->numerador;
					}
				}
				try {
					return (empty($result->numerador) && !is_numeric($result->numerador))?null:('$ '.number_format($result->numerador, 0, ',', '.'));
				} catch (\Exception $e) {
					return $result->numerador;
				}

			}
		)
			->addColumn(
			'denominador_format',
			function ($result) {
				if (in_array($result->indicador, ['5|1', '5|3'])) {
					return (empty($result->denominador) && !is_numeric($result->denominador))?null:($result->denominador);
				} else if (in_array($result->indicador, ['1|1', '1|2', '2|1', '2|2', '2|3', '2|4', '5|4'])) {
					try {
						return (empty($result->denominador) && !is_numeric($result->denominador))?null:(number_format($result->denominador, 0, ',', '.'));
					} catch (\Exception $e) {
						return $result->denominador;
					}
				}
				try {
					return (empty($result->denominador) && !is_numeric($result->denominador))?null:('$ '.number_format($result->denominador, 0, ',', '.'));
				} catch (\Exception $e) {
					return $result->denominador;
				}

			}
		)
			->addColumn(
			'estado',
			function ($result) {
				$var_state = $this->checkState($result->id);
				if (!in_array($result->indicador, ['5|1', '5|3', '5|4', '5|5'])) {
					$var_state['value'] == 'INCOMPLETO'?$tipo_valor = "":$tipo_valor = " % ";
				} else {
					$tipo_valor = "";
				}
				return '<button class="btn btn-'.$var_state['color'].' btn-xs"> '.$var_state['value'].$tipo_valor.'</button>';
			}
		)
			->make(true);
	}

	/**
	 * Arma el excel historico
	 * @param $periodo, $provincia, $indicador
	 *
	 * @return excel
	 */
	public function excelHistorico($periodo_desde, $periodo_hasta, $provincia, $indicador) {

		$results = $this->datosListadoTabla('9999-99', $provincia);

		$this->datosExtraHistorico($results, $indicador, $periodo_desde, $periodo_hasta);

		$results = collect($results->get());

		$results->transform(function ($item, $key) {
				$state = $this->checkState($item->id);
				$item->estado = $state['value'];
				$item->color = $state['color'];
				$item->indicador = strtr($item->indicador, array("|" => "."));
				return $item;
			});

		$data = ['historico' => $results, 'periodo_desde' => $periodo_desde, 'periodo_hasta' => $periodo_hasta, 'indicador' => $indicador, 'provincia' => $provincia];

		return Excel::create("Historico_".$provincia."_".$periodo_desde."_a_".$periodo_hasta."_".str_replace("|", ".", $indicador)."_".date('Y-m-d'), function ($e) use ($data) {
				$e->sheet('Historico_SUMAR', function ($s) use ($data) {
						$s->loadView('tablero.tabla_historico', $data);
						$s->setColumnFormat(array('A' => '@', 'B' => '@', 'C' => '@', 'D' => '@', 'E' => '@'));
						$i = 6;//COMIENZO DE DATOS EN EXCEL
						foreach ($data['historico'] as $row_fields) {

							$s->row($i, ['Col 6']);
							switch (true) {
								case ($row_fields['color'] == "success"):
									$color_background = '#00FF00';
									break;

								case ($row_fields['color'] == "warning"):
									$color_background = '#FFFF00';
									break;

								case ($row_fields['color'] == "danger"):
									$color_background = '#FF0000';
									break;

								default:
									$color_background = '#C0C0C0';
									break;
							}
							$s->cell('F'.$i, function ($color) use ($color_background) {$color->setBackground($color_background);});

							$i++;
						}
					});
			})
			->download('xls');
	}
}
