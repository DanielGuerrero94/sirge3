<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Geo\Provincia;
use App\Models\Lote;
use App\Models\PUCO\Osp;

use App\Models\PUCO\ProcesoPuco as Pucop;

use App\Models\PUCO\Provincia as OspProvincias;
use App\Models\Subida;

use App\Models\SubidaOsp;
use App\Models\Trazadoras\Header;
use Auth;
use Datatables;
use DB;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use Validator;

class PadronesController extends Controller {
	private $_rules_trazadoras = [
		'trazadora' => 'required|in:01,02,03,04,05,06,07,08,09,10,11,12,13,14,15',
		'provincia' => 'required|exists:geo.provincias,id_provincia',
		'periodo'   => 'required|integer|digits:6',
	];

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
		setlocale(LC_TIME, 'es_ES.UTF-8');
	}

	/**
	 * Devuelve la vista principal
	 * @param string $padron
	 * @param int $id
	 *
	 * @return null
	 */
	public function getMain($id) {

		$archivos_pendientes = Subida::where('id_estado', 1)->where('id_padron', $id)->where('id_usuario', Auth::user()->id_usuario)->count();

		$lotes_pendientes = Lote::join('sistema.subidas', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
			->where('id_padron', $id)
			->where('sistema.lotes.id_estado', 1);

		$lotes_no_declarados = DB::table('sistema.lotes as l')
			->join('sistema.subidas as s', 'l.id_subida', '=', 's.id_subida')
			->join('sistema.lotes_aceptados as a', 'l.lote', '=', 'a.lote')
			->where('s.id_padron', $id)
			->whereNotIn('l.lote', function ($q) {
				$q->select(DB::raw('unnest(lote)'))
					->from('ddjj.sirge');
			});

		if (Auth::user()->id_entidad == 2) {
			$lotes_pendientes    = $lotes_pendientes->where('id_provincia', Auth::user()->id_provincia)->count();
			$lotes_no_declarados = $lotes_no_declarados->where('id_provincia', Auth::user()->id_provincia)->count();
		} else {
			$lotes_pendientes    = $lotes_pendientes->count();
			$lotes_no_declarados = $lotes_no_declarados->count();
		}

		// return $lotes_pendientes;

		$data = [
			'page_title'          => strtoupper($this->getName($id)),
			'id_padron'           => $id,
			'archivos_pendientes' => $archivos_pendientes,
			'lotes_pendientes'    => $lotes_pendientes,
			'lotes_no_declarados' => $lotes_no_declarados
		];
		return view('padrones.main', $data);
	}

	/**
	 * Devuelve la ruta donde guardar el archivo
	 * @param int $id
	 *
	 * @return string
	 */
	protected function getName($id, $route = false) {

		switch ($id) {
			case 1:
				$p = 'prestaciones';
				break;
			case 2:
				$p = 'fondos';
				break;
			case 3:
				$p = 'comprobantes';
				break;
			case 4:
				$p = 'osp';
				break;
			case 5:
				$p = 'profe';
				break;
			case 6:
				$p = 'sss';
				break;
			case 7:
				$p = 'trazadoras';
				break;
			case 8:
				$p = 'tablero';
				break;
			default:
				break;
		}
		if ($route) {
			return '../storage/uploads/'.$p;
		} else {
			return ucwords($p);
		}
	}

	/**
	 * Devuelve la vista para subir un padrón
	 * @param int $id
	 *
	 * @return null
	 */
	public function getUpload($id) {
		$data = [
			'page_title' => 'Subir archivos',
			'id_padron'  => $id
		];

		if ($id == 4) {
			$osp           = OspProvincias::where('codigo_osp', '<', 997001)->with('descripcion')->get();
			$data['obras'] = $osp;
		}
		return view('padrones.upload-files', $data);
	}

	/**
	 * Determina si es posible o no subir un archivo del padrón en cuestión. Para eso,
	 * chequea que no haya ningún lote pendiente del mismo padrón.
	 * @param  [smallint] $id [id_padron]
	 * @return [bool]     [respuesta booleana]
	 */
	public function checkNoPending($id) {
		if ($id <> 7) {
			$pending_lotes = Subida::join('sistema.lotes', 'sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
				->where('id_padron', $id)
				->where('sistema.lotes.id_provincia', Auth::user()->id_provincia)
				->where('sistema.lotes.id_estado', 1)
				->select('sistema.lotes.lote')
				->get()
				->toArray();

			if (!empty($pending_lotes)) {
				return array('status' => 'error', 'detalle' => json_encode($pending_lotes));
			} else {
				return array('status' => 'ok');
			}
		}
		return array('status' => 'ok');
	}

	/**
	 * Guarda el archivo en el sistema
	 * @param $r Request
	 *
	 * @return json
	 */
	public function postUpload(Request $r) {

		$r      = (object) $r;
		$status = $this->checkNoPending($r->id_padron);

		if ($status['status'] == 'error') {
			return response()->json(['success' => 'false',
					'errors'                         => "No puede cargar nuevos archivos habiendo lotes pendientes en el mismo padrón. Dichos lotes son ".$status['detalle']]);
		}

		$nombre_archivo = uniqid().'.txt';

		$destino = $this->getName($r->id_padron, true);
		$s       = new Subida;

		$s->id_usuario      = Auth::user()->id_usuario;
		$s->id_padron       = $r->id_padron;
		$s->nombre_original = $r->file->getClientOriginalName();
		$s->nombre_actual   = $nombre_archivo;
		$s->size            = $r->file->getClientSize();
		$s->id_estado       = 1;

		try {
			$r->file('file')->move($destino, $nombre_archivo);
		} catch (FileException $e) {
			$s->delete();
			return response()->json(['success' => 'false',
					'errors'                         => "Ha ocurrido un error: ".$e->getMessage()]);
		}
		if ($s->save()) {
			switch ($r->id_padron) {
				case 4:
					if ($r->codigo_osp == 0) {
						$s->delete();
						unlink($destino.'/'.$nombre_archivo);
						return response()->json(['success' => 'false',
								'errors'                         => "Debe elegir la Obra Social a reportar"]);
					} else {
						$codigo_final = $r->codigo_osp;
						$id_archivo   = 1;
						Osp::where('codigo_os', $r->codigo_osp)->delete();

						$pucop = Pucop::join('sistema.lotes', 'sistema.lotes.lote', '=', 'puco.procesos_obras_sociales.lote')
							->join('sistema.subidas', 'sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
							->join('sistema.subidas_osp', 'sistema.subidas_osp.id_subida', '=', 'sistema.subidas.id_subida')
							->select('puco.procesos_obras_sociales.*', 'sistema.subidas_osp.*')
							->where('periodo', date('Ym'))
							->where('codigo_osp', $r->codigo_osp)
							->first();

						if (isset($pucop->lote)) {
							$np            = Lote::find($pucop->lote);
							$np->id_estado = 4;
							$np->save();
						}
					}
					break;
				case 5:
					$id_archivo   = 1;
					$codigo_final = 997001;
					break;
				case 6:
					if ($r->id_sss == 0) {
						$s->delete();
						unlink($destino.'/'.$nombre_archivo);
						return response()->json(['success' => 'false',
								'errors'                         => 'Debe elegir el ID del archivo de la SSS']);
					} else {
						$id_archivo   = $r->id_sss;
						$codigo_final = 998001;
					}

					break;
				case 7:
					try {
						$result = $this->identificarTrazadora($s->nombre_original);
					} catch (ErrorException $e) {
						$s->delete();
						return response()->json(['success' => 'false',
								'errors'                         => $e->getMessage()]);
					}
					if ($result['status'] == 'error') {
						$s->delete();
						return response()->json(['success' => 'false',
								'errors'                         => $result['detalle']]);
					}
					unset($result);
					break;
				case 8:
					try {
						$result = $this->checkAccepted($s->id_subida);
					} catch (ErrorException $e) {
						$s->delete();
						return response()->json(['success' => 'false',
								'errors'                         => $e->getMessage()]);
					}
					if ($result['status'] == 'error') {
						$s->delete();
						return response()->json(['success' => 'false',
								'errors'                         => $result['detalle']]);
					}
					unset($result);
					break;
			}

			$id_subida = $s->id_subida;

			if (isset($codigo_final)) {
				$so             = new SubidaOsp;
				$so->id_subida  = $s->id_subida;
				$so->codigo_osp = $codigo_final;
				$so->id_archivo = $id_archivo;
				$so->save();
			}

			return response()->json(['success' => 'true', 'file' => $r->file->getClientOriginalName(), 'nombre_padron' => strtolower($this->getName($r->id_padron)), 'id_subida' => $s->id_subida, 'ruta_procesar' => 'procesar-'.strtolower($this->getName($r->id_padron))]);
			unset($s);
		}
	}

	/**
	 * Devuelve la vista para procesar archivos
	 *
	 * @return null
	 */
	public function listadoArchivos($id) {
		$data = [
			'page_title'    => 'Archivos subidos',
			'id_padron'     => $id,
			'ruta_procesar' => 'procesar-'.strtolower($this->getName($id))
		];
		return view('padrones.process-files', $data);
	}

	/**
	 * Devuelve el listado de archivos subidos
	 * @param int $id_padron
	 *
	 * @return json
	 */
	public function listadoArchivosTabla($id_padron) {
		$archivos = Subida::where('id_padron', $id_padron)
			->where('id_estado', 1)
			->where('id_usuario', Auth::user()->id_usuario)
			->get();
		return Datatables::of($archivos)
			->addColumn('action', function ($archivo) {
				return '
              	<button id-subida="'.$archivo->id_subida.'" class="procesar btn btn-info btn-xs"><i class="fa fa-pencil-square-o"></i> Procesar</button>
              	<button id-subida="'.$archivo->id_subida.'" class="eliminar btn btn-danger btn-xs"><i class="fa fa-pencil-square-o"></i> Eliminar</button>';
			})
			->make(true);
	}

	/**
	 * Elimina un archivo
	 * @param int $id
	 *
	 * @return json
	 */
	public function eliminarArchivo($id) {
		$f            = Subida::find($id);
		$f->id_estado = 4;
		if ($f->save()) {
			try {
				unlink($this->getName($f->id_padron, true).'/'.$f->nombre_actual);
				return 'Se ha eliminado el archivo';
			} catch (ErrorException $e) {
				return 'Se ha eliminado el archivo';
			}
		}
	}

	/**
	 * Devuelve listado de 6 meses
	 * @param int $meses
	 *
	 * @return array
	 */
	protected function getMesesArray($meses) {

		$dt = new \DateTime();
		$dt->modify("-$meses months");

		for ($i = 0; $i < $meses; $i++) {
			$dt->modify('+1 month');
			$array[$i] = ucwords(strftime("%b %y", $dt->getTimeStamp()));
		}
		return $array;
	}

	/**
	 * Inserta elementos en el array
	 *
	 * @return null
	 */
	protected function insertDummy() {

		$fuentes = [
			'prestaciones',
			'comprobantes',
			'fondos'
		];

		$provincias = [
			'01', '02', '03', '04', '05', '06',
			'07', '08', '09', '10', '11', '12',
			'13', '14', '15', '16', '17', '18',
			'19', '20', '21', '22', '23', '24',
		];

		for ($i = 0; $i < 6; $i++) {
			foreach ($fuentes as $fuente) {
				foreach ($provincias as $provincia) {
					$periodos[$provincia][$fuente][$i] = -1;
					$periodos[$provincia]['data']      = Provincia::find($provincia);
				}
			}
		}

		return $periodos;
	}

	/**
	 * Devuelve la vista del consolidado
	 *
	 * @return null
	 */
	public function getConsolidado() {

		$consolidado = $this->insertDummy();

		$dt = new \DateTime();
		$dt->modify('-6 months');

		for ($i = 0; $i < 6; $i++) {
			$dt->modify('+1 month');
			$dt->modify('first day of this month');
			$min = $dt->format('Y-m-d');
			$dt->modify('last day of this month');
			$max = $dt->format('Y-m-d');
			$dt->modify('first day of this month');

			$prestaciones = Lote::join('sistema.subidas as s', 'sistema.lotes.id_subida', '=', 's.id_subida')
				->where('id_padron', 1)
				->where('sistema.lotes.id_estado', 3)
				->whereBetween('fin', [$min, $max])
				->select('sistema.lotes.id_provincia', DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo"), DB::raw('sum(registros_in) as c'))
				->groupBy(DB::raw('1'))
				->groupBy(DB::raw('2'))
				->orderBy(DB::raw('2'))
				->orderBy(DB::raw('1'))
				->get();

			foreach ($prestaciones as $prestacion) {
				$consolidado[$prestacion->id_provincia]['prestaciones'][$i] = $prestacion->c;
			}

			$comprobantes = Lote::join('sistema.subidas as s', 'sistema.lotes.id_subida', '=', 's.id_subida')
				->where('id_padron', 3)
				->where('sistema.lotes.id_estado', 3)
				->whereBetween('fin', [$min, $max])
				->select('sistema.lotes.id_provincia', DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo"), DB::raw('sum(registros_in) as c'))
				->groupBy(DB::raw('1'))
				->groupBy(DB::raw('2'))
				->orderBy(DB::raw('2'))
				->orderBy(DB::raw('1'))
				->get();

			foreach ($comprobantes as $comprobante) {
				$consolidado[$comprobante->id_provincia]['comprobantes'][$i] = $comprobante->c;
			}

			$fondos = Lote::join('sistema.subidas as s', 'sistema.lotes.id_subida', '=', 's.id_subida')
				->where('id_padron', 2)
				->where('sistema.lotes.id_estado', 3)
				->whereBetween('fin', [$min, $max])
				->select('sistema.lotes.id_provincia', DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo"), DB::raw('sum(registros_in) as c'))
				->groupBy(DB::raw('1'))
				->groupBy(DB::raw('2'))
				->orderBy(DB::raw('2'))
				->orderBy(DB::raw('1'))
				->get();

			foreach ($fondos as $fondo) {
				$consolidado[$fondo->id_provincia]['fondos'][$i] = $fondo->c;
			}
		}

		$data = [
			'page_title'  => 'Consolidado',
			'consolidado' => $consolidado,
			'meses'       => $this->getMesesArray(6)
		];

		return view('padrones.consolidado', $data);
	}

	/**
	 * Armar array vacio
	 *
	 * @return array
	 */
	protected function generarDummy($array) {

		return array_fill_keys($array, 0);
	}

	/**
	 * Graficar la progresión de la fuente de datos
	 * @param int $padron
	 * @param string $provincia
	 *
	 * @return null
	 */
	public function graficarPadron($padron, $provincia) {

		$meses = $this->getMesesArray(24);
		$aux   = $this->generarDummy($meses);

		$dt = new \DateTime();
		$dt->modify('last day of this month');
		$max = $dt->format('Y-m-d');
		$dt->modify('first day of this month');
		$dt->modify("-23 months");
		$min = $dt->format('Y-m-d');

		$prestaciones = Lote::join('sistema.subidas as s', 'sistema.lotes.id_subida', '=', 's.id_subida')
			->where('id_padron', $padron)
			->where('sistema.lotes.id_estado', 3)
			->where('sistema.lotes.id_provincia', $provincia)
			->whereBetween('fin', [$min, $max])
			->select('sistema.lotes.id_provincia', DB::raw("extract (year from fin) :: text || lpad (extract(month from fin) :: text , 2 , '0') as periodo"), DB::raw('sum(registros_in) as c'))
			->groupBy(DB::raw('1'))
			->groupBy(DB::raw('2'))
			->orderBy(DB::raw('2'))
			->orderBy(DB::raw('1'))
			->get();

		foreach ($prestaciones as $prestacion) {
			$dt       = \DateTime::createFromFormat('Ym', $prestacion->periodo);
			$pd       = ucwords(strftime("%b %y", $dt->getTimeStamp()));
			$aux[$pd] = $prestacion->c;
		}

		foreach ($aux as $a) {
			$series[0]['name']   = 'Registros reportados';
			$series[0]['data'][] = $a;
		}

		$data = [
			'page_title' => 'Progresión reporte fuente de datos',
			'series'     => json_encode($series),
			'categorias' => json_encode($meses)
		];

		return view('padrones.grafico-consolidado', $data);
	}

	/**
	 * Identifica con el nombre del archivo la provincia, trazadora y periodo a la que corresponde.
	 * @param string $nombre
	 *
	 * @return resource
	 */
	public function identificarTrazadora($nombre, $carga_archivo = null) {
		$archivo = explode('_', $nombre);
		if (isset($archivo[3])) {
			$trazadora = str_replace('Trz', '', $archivo[0]);
			$periodo   = intval($archivo[2].str_pad(intval(str_replace(strtoupper('.TXT'), '', $archivo[3])), 2, '0', STR_PAD_LEFT));
			if (count($archivo) == 5) {
				$detalle = strtoupper(explode('.', $archivo[4])[0]) == 'DET'?'S':'N';
			} else {
				$detalle = 'N';
			}

			$a_nombre_archivo = ["trazadora" => $trazadora, "provincia" => $archivo[1], "periodo" => $periodo];

			$v = Validator::make($a_nombre_archivo, $this->_rules_trazadoras);

			if ($v->fails()) {
				return array('status' => 'error', 'detalle' => json_encode(["mensaje" => "El nombre del archivo no cumpĺe el formato para la carga de Trazadoras", "formato_correcto" => "Trz[NUMERO_TRAZADORA]_[PROVINCIA]_[YEAR]_[MES](_Det).txt", "valores" => json_encode($a_nombre_archivo)]));
			}

			if (Header::where('trazadora', intval($trazadora))
					->where('periodo', $periodo)
				->where('provincia', $archivo[1])
					->where('detalle', $detalle)
				->count() == 1) {
				return array('status' => 'error', 'detalle' => json_encode(["mensaje" => "La trazadora para dicha provincia ya ha sido cargada en el periodo", "valores" => array("Trazadora: " => $trazadora, "Periodo: " => $periodo, "Provincia: " => $archivo[1], "Detalle: " => $detalle)]));
			} else {
				return array('status' => 'ok');
			}
		} else {
			return array('status' => 'error', 'detalle' => json_encode(["mensaje" => "El nombre del archivo no cumple el formato para la carga de Trazadoras", "formato_correcto" => "Trz[NUMERO_TRAZADORA]_[PROVINCIA]_[YEAR]_[MES](_Det).txt"]));
		}
	}

	/**
	 * Identifica con el nombre del archivo la provincia, trazadora y periodo a la que corresponde.
	 * @param string $nombre
	 *
	 * @return resource
	 */
	public function checkAccepted($id) {
		$info = Subida::findOrFail($id);

		try {
			$fh = fopen('/var/www/html/sirge3/storage/uploads/tablero/'.$info->nombre_actual, 'r');
		} catch (ErrorException $e) {
			return array('status' => 'error', 'detalle' => json_encode(["mensaje" => "No se encuentra el archivo"]));
		}

		if (!$fh) {
			return response()->json(['success' => 'false', 'errors' => "El archivo no ha podido procesarse"]);
		}

		fgets($fh);
		$linea    = explode(',', trim(fgets($fh), "\r\n"));
		$datetime = DateTime::createFromFormat('d/m/Y', $linea[0]);
		$periodo  = $datetime->format('Y-m');
		return array('status' => 'error', 'detalle' => json_encode(["mensaje" => "El periodo ingresado ya fue aceptado"]));
	}
}
