<?php

namespace App\Http\Controllers;

use App;
use App\Http\Controllers\Controller;

use App\Models\AccesoWS;
use App\Models\Excepciones;
use App\Models\GenerarRechazoLote;
use App\Models\Lote;
use App\Models\Rechazo;

use App\Models\RechazoAlternativo;

use App\Models\Tarea;
use App\Models\Usuario;

use Excel;
use Exception;

use Mail;
use ZipArchive;

class RechazosController extends Controller {
	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		// $this->middleware('auth');
	}

	/**
	 * Devuelve un csv con los rechazos
	 * @param int $lote
	 *
	 * @return json
	 */
	public function verRechazos($lote) {

		$acc     = new AccesoWS;
		$acc->ws = 1;
		$acc->save();

		$rechazos = Rechazo::select('lote', 'registro', 'motivos', 'created_at')->where('lote', $lote)->get();

		if (!count($rechazos)) {
			return response()->json(['mensaje' => 'El lote seleccionado fue eliminado o no posee rechazos']);
		}

		foreach ($rechazos as $key => $rechazo) {
			$rechazos[$key]['registro'] = json_decode($rechazo['registro']);
			$rechazos[$key]['motivos']  = json_decode($rechazo['motivos']);
		}

		return response()->json($rechazos);
	}

	/**
	 * Testeo web service rechazo
	 * @param int $lote
	 *
	 * @return string
	 */
	public function curlRechazo($lote) {
		// Crear un nuevo recurso cURL
		$ch = curl_init();

		// Establecer URL y otras opciones apropiadas
		curl_setopt($ch, CURLOPT_URL, "http://localhost/sirge3/public/rechazos/$lote");
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Capturar la URL y pasarla a una variable
		$rechazos = json_decode(curl_exec($ch), true);

		// Cerrar el recurso cURL y liberar recursos del sistema
		curl_close($ch);

		return response()->json($rechazos);
	}

	/**
	 * Descarga la tabla de rechazos en el padron
	 *
	 * @return null
	 */
	public function generarExcelRechazos($lote) {

		$rechazo = GenerarRechazoLote::where('lote', $lote)->get();

		if (!$rechazo     ->isEmpty()) {
			return response()->json(['Estado' => 'Generacion rechazada por excel ya existente', 'lote' => $lote, 'registros_rechazados' => $rechazo[0]->registros]);
		}

		$start = microtime(true);

		$padron = Lote::join('sistema.subidas', 'sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
			->where('lote', $lote)
			->whereIn('sistema.lotes.id_estado', [1, 3])
			->where('sistema.lotes.registros_out', '>', 0)
			->where('id_padron', '<>', 7)
			->select('id_padron', 'registros_out')
			->first();

		try {
			if (!isset($padron)) {
				throw new Exception("Este lote no esta ACEPTADO o PENDIENTE. No puede generar lotes en otro tipo de condicion. Tenga en cuenta que tampoco se generan excels de lotes sin rechazos.");
			}
		} catch (Exception $e) {
			return response()->json($e->getMessage());
		}

		$this->cargarComienzoExcelRechazo($lote, $padron->registros_out);

		$rechazos = Rechazo::select('registro', 'motivos')->where('lote', $lote)
		                                                  ->take(15)->get();

		$id_padron = $padron->id_padron;

		$data = ['rechazos' => $rechazos, 'padron' => $padron->id_padron];

		Excel::create($lote, function ($e) use ($data, $padron) {
				$e->sheet('Rechazos_SUMAR', function ($s) use ($data, $padron) {
						$s->setHeight(1, 20);
						$s->setColumnFormat([
								'B' => '0',
								'H' => '\PHPExcel_Style_NumberFormat::FORMAT_TEXT'
							]);
						$s->loadView('padrones.excel-tabla.'.$padron->id_padron, $data);
					});
			})
			->store('xlsx', storage_path('exports/rechazos/'));
		//->export('xls');

		$zip = new ZipArchive();
		$zip->open('/var/www/html/sirge3/storage/exports/rechazos/'.$lote.'.zip', ZipArchive::CREATE);
		$zip->addFile('/var/www/html/sirge3/storage/exports/rechazos/'.$lote.'.xlsx', $lote.'.xlsx');
		$zip->close();
		unlink('/var/www/html/sirge3/storage/exports/rechazos/'.$lote.'.xlsx');

		$this->cargarFinalExcelRechazo($lote, $start);
		return $this->descargarExcelLote($lote);
	}

	/**
	 * Genera un zip con los rechazos del lote.
	 * @lote integer
	 * @return null
	 */
	public function generarExcelRechazosAutomatizado($lote) {

		$start = microtime(true);

		$padron = Lote::join('sistema.subidas', 'sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
			->where('lote', $lote)
			->whereIn('sistema.lotes.id_estado', [1, 3])
			->where('sistema.lotes.registros_out', '>', 0)
			->where('id_padron', '<>', 7)
			->select('id_padron', 'registros_out')
			->first();

		$this->cargarComienzoExcelRechazo($lote, $padron->registros_out);

		$rechazos = Rechazo::select('registro', 'motivos')->where('lote', $lote)
		                                                  ->get();

		$id_padron = $padron->id_padron;

		$data = ['rechazos' => $rechazos, 'padron' => $padron->id_padron];

		Excel::create($lote, function ($e) use ($data, $padron) {
				$e->sheet('Rechazos_SUMAR', function ($s) use ($data, $padron) {
						$s->setHeight(1, 20);
						$s->setColumnFormat([
								'B' => '0',
								'H' => '@'
							]);
						$s->loadView('padrones.excel-tabla.'.$padron->id_padron, $data);
					});
			})
			->store('xlsx', storage_path('exports/rechazos/'));

		$zip = new ZipArchive();
		$zip->open('/var/www/html/sirge3/storage/exports/rechazos/'.$lote.'.zip', ZipArchive::CREATE);
		$zip->addFile('/var/www/html/sirge3/storage/exports/rechazos/'.$lote.'.xlsx', $lote.'.xlsx');
		$zip->close();
		unlink('/var/www/html/sirge3/storage/exports/rechazos/'.$lote.'.xlsx');

		$this->cargarFinalExcelRechazo($lote, $start);
	}

	/**
	 * Genera los lotes nuevos.
	 *
	 * @return null
	 */
	public function generarRechazosLotesNuevos() {
		if (Tarea::where('estado', 1)->count() == 0 && GenerarRechazoLote::where('estado', 1)->count() == 0) {
			$ultimos_lotes_generados = GenerarRechazoLote::lists('lote');

			$lotes = Lote::join('sistema.subidas', 'sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
				->whereIn('sistema.lotes.id_estado', [1, 3])
				->where('sistema.lotes.inicio', '>', '2016-05-01')
				->where('sistema.subidas.id_padron', '<', 5)
				->where('sistema.lotes.registros_out', '>', 0)
				->where('sistema.lotes.registros_out', '<', 200000)
				->whereNotIn('sistema.lotes.lote', $ultimos_lotes_generados)
				->orderBy('sistema.lotes.lote', 'asc')
				->lists('sistema.lotes.lote');

			Tarea::where('nombre', 'rechazos_lotes')->update(['estado' => 1]);
			foreach ($lotes as $key                                    => $lote) {
				$this->generarExcelRechazosAutomatizado($lote);
			}
			Tarea::where('nombre', 'rechazos_lotes')->update(['estado' => 2]);
		}
	}

	/**
	 * Decargar la tabla del lote
	 * @lote integer
	 * @return null
	 */
	public function descargarExcelLote($lote) {
		return response()->download('/var/www/html/sirge3/storage/exports/rechazos/'.$lote.'.zip');
	}

	/**
	 * Agrega el nuevo lote a la tabla de tareas ejecutadas en estado 1 (EN EJECUCION).
	 *
	 * @return null
	 */
	protected function cargarComienzoExcelRechazo($lote, $registros) {

		$rechazo = GenerarRechazoLote::where('lote', $lote)->get();

		if ($rechazo->isEmpty()) {
			$tarea                      = new GenerarRechazoLote();
			$tarea->lote                = $lote;
			$tarea->estado              = 1;
			$tarea->tiempo_de_ejecucion = 0;
			$tarea->registros           = $registros;
			$saved                      = $tarea->save();
			if (!$saved) {
				App::abort(500, 'Error al guardar registro en la base');
			}
		}
	}

	/**
	 * Actualiza el lote en tareas ejecutadas al estado 2 (PROCESADO) con su tiempo de ejecucion.
	 *
	 * @return null
	 */
	protected function cargarFinalExcelRechazo($lote, $start) {

		$tarea = GenerarRechazoLote::where('lote', $lote)
			->update(['estado' => 2, 'tiempo_de_ejecucion' => (microtime(true)-$start)]);

		$objetc_lote = Lote::find($lote);
		$u           = Usuario::find($objetc_lote->id_usuario);
		//$u = Usuario::find(191);

		try {
			Mail::send('emails.excel-rechazo', ['usuario' => $u, 'lote' => $lote], function ($m) use ($u) {
					$m->from('sirgeweb@sumar.com.ar', 'SIRGe Web');
					$m->to($u->email, $u->nombre);
					$m->to('javier.minsky@gmail.com', $u->nombre);
					$m->subject('Excel generado');
				});
		} catch (\Exception $e) {
			$new_e         = new Excepciones();
			$new_e->clase  = __CLASS__;
			$new_e->metodo = __FUNCTION__;
			$new_e->error  = $e->getMessage();
			$new_e->save();
		}

	}

	/**
	 * Convierte los rechazos de los lotes en un único registro json.
	 *
	 * @return null
	 */
	protected function convertirEnJsonDeJsons() {

		$lotes = Rechazo::whereBetween('lote', [6400, 6500])
			->groupBy('lote')	->get();

		$lotes_a_convertir = Rechazo::where('lote', 6962)->take(15)->get();

		$json_de_jsons = array();

		foreach ($lotes_a_convertir as $rechazo) {
			$json_de_jsons[] = array('registro' => (array) json_decode($rechazo->registro), 'motivos' => (array) json_decode($rechazo->motivos));
		}

		$insert_rechazo           = new RechazoAlternativo();
		$insert_rechazo->lote     = 6962;
		$insert_rechazo->registro = json_encode($json_de_jsons);
		$insert_rechazo->save();

		echo '<pre>'.json_encode($json_de_jsons, JSON_PRETTY_PRINT).'</pre>';
	}
}
