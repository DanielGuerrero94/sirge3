<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Lote;
use App\Models\PUCO\Osp;
use App\Models\PUCO\ProcesoPuco as Proceso;

use App\Models\PUCO\Provincia;
use App\Models\PUCO\Puco;

use Datatables;
use DB;

use Mail;
use Log;

use ZipArchive;

class PucoController extends Controller {
	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Devuelve la vista principal para generar el PUCO
	 *
	 * @return null
	 */
	public function getGenerar() {

		$data = [
			'page_title' => 'Generar PUCO '.date('M y'),
			'puco_ready' => $this->checkPuco(),
			'meses'      => $this->reportesEnPeriodo(),
			'periodo'    => date('M y')
        ];
        
		return view('puco.generar', $data);
	}

	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function estadisticasTabla() {
		$datos = Puco::all();
		return Datatables::of($datos)->make(true);
	}

	/**
	 * Genera una contraseña aleatoria
	 *
	 * @return string
	 */
	private function password($length = 6) {
		$chars    = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$?";
		$password = substr(str_shuffle($chars), 0, $length);
		return $password;
	}

	/**
	 * Devuelve el JSON para la datatable
	 *
	 * @return json
	 */
	public function resumenTabla() {
		$datos = Provincia::leftJoin('sistema.subidas_osp', 'sistema.subidas_osp.codigo_osp', '=', 'puco.obras_sociales_provinciales.codigo_osp')
			->leftJoin('sistema.subidas', 'sistema.subidas_osp.id_subida', '=', 'sistema.subidas.id_subida')
			->leftJoin('sistema.lotes', function ($j) {
				$j->on('sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
					->where('sistema.lotes.id_estado', '=', 3);
			})
			->leftJoin('puco.procesos_obras_sociales', function ($j) {
				$j->on('sistema.lotes.lote', '=', 'puco.procesos_obras_sociales.lote');
			})->leftJoin('puco.obras_sociales', 'puco.obras_sociales_provinciales.codigo_osp', '=', 'puco.obras_sociales.codigo_osp')
		   ->where('puco.procesos_obras_sociales.periodo', '=', date('Ym'));

		return Datatables::of($datos)->make(true);
	}

	/**
	 * Devuelve el estado del PUCO
	 *
	 * @return int
	 */
	private function checkPuco() {
		return Proceso::join('sistema.lotes', 'puco.procesos_obras_sociales.lote', '=', 'sistema.lotes.lote')
			->where('periodo', date('Ym'))
			->where('id_estado', 3)
			->count();
	}

	/**
	 * Devuelve el nº de beneficiarios
	 *
	 *
	 * @return int
	 */
	public function getBeneficiarios($periodo) {
		return Proceso::join('sistema.lotes', 'puco.procesos_obras_sociales.lote', '=', 'sistema.lotes.lote')
			->where('periodo', $periodo)
			->where('id_estado', 3)
			->select('registros_in')
			->sum('registros_in');
	}

	/**
	 * Guarda el resumen del PUCO
	 * @param string $pass
	 * @param int $beneficiarios
	 *
	 * @return bool
	 */
	private function actualizarPuco($pass, $beneficiarios) {
		$np            = Puco::findOrNew(date('Ym'));
		$np->periodo   = date('Ym');
		$np->clave     = $pass;
		$np->registros = $beneficiarios;
		return $np->save();
	}

	/**
	 * Notifica por email
	 *
	 *
	 */
	private function notificar($beneficiarios, $pass) {
		Mail::send('emails.noti-puco', ['mes' => date('F'), 'beneficiarios' => $beneficiarios, 'pass' => $pass], function ($m) {
				$m->from('sirgeweb@sumar.com.ar', 'SIRGe Web');
				$m->to('sistemasuec@gmail.com');
				$m->to('javier.minsky@gmail.com');
			//	$m->to('rodrigo.cadaval.sumar@gmail.com');
			//	$m->to('danielcussumar@gmail.com');
				$m->subject('PUCO '.date('Ym'));
			});
	}

	/**
	 * Genera el PUCO
	 *
	 * @return string
	 */
	public function generar() {

        Log::info("Ejecuta query");

		$datos = Provincia::leftJoin('sistema.subidas_osp', 'sistema.subidas_osp.codigo_osp', '=', 'puco.obras_sociales_provinciales.codigo_osp')
			->leftJoin('sistema.subidas', 'sistema.subidas_osp.id_subida', '=', 'sistema.subidas.id_subida')
			->leftJoin('sistema.lotes', function ($j) {
				$j->on('sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
					->where('sistema.lotes.id_estado', '=', 3);
			})
			->leftJoin('puco.procesos_obras_sociales', function ($j) {
				$j->on('sistema.lotes.lote', '=', 'puco.procesos_obras_sociales.lote');
			})->leftJoin('puco.obras_sociales', 'puco.obras_sociales_provinciales.codigo_osp', '=', 'puco.obras_sociales.codigo_osp')
		   ->where('puco.procesos_obras_sociales.periodo', '=', date('Ym'))
		   ->get();

        Log::info("datos ".json_encode(count($datos)));
		$i = 0;

		foreach ($datos as $fila) {
            Log::info("lote a insertar ".json_encode($fila));
			$objeto_a_insertar[$i]['lote']         = $fila->lote;
			$objeto_a_insertar[$i]['id_provincia'] = $fila->id_provincia;
			$objeto_a_insertar[$i]['nombre']       = $fila->nombre;
			$objeto_a_insertar[$i]['registros_in'] = $fila->registros_in;
			$objeto_a_insertar[$i]['periodo']      = date('Ym');
			$i++;
		}

		DB::table('puco.cantidades_mensuales')->where('periodo', '=', date('Ym'))->delete();
		DB::table('puco.cantidades_mensuales')->insert($objeto_a_insertar);

		Osp::where('numero_documento', '46074543')->update(['nombre_apellido'                                 => 'GONZALEZ D AMICO MARIA CLARA']);
		Osp::where('numero_documento', '4313713')->where('tipo_documento', 'DNI')->update(['nombre_apellido'  => 'ACUÑA PEDRO ISIDORO']);
		Osp::where('numero_documento', '11231247')->where('tipo_documento', 'DNI')->update(['nombre_apellido' => 'NUÑEZ SILVIA LILIANA']);
		Osp::where('numero_documento', '55411264')->where('tipo_documento', 'DNI')->delete();

		$password = $this->password();

        Log::info("ejecutar copiar_puco_en_servidor");
		DB::statement("	SELECT public.copiar_puco_en_servidor(); ");

        Log::info("copio a servidor");

		$puco = file_get_contents('/var/www/html/sirge3/storage/swap/puco.txt');
		$puco = str_replace("\n", "\r\n", $puco);
		file_put_contents('/var/www/html/sirge3/storage/swap/PUCO_'.date("Y-m").'.txt', $puco);
		unset($puco);

        Log::info("genero PUCO_.txt");

		//$sys = "sudo todos < puco.txt > PUCO_".date('Y-m')."txt";
		//exec($sys);
		//unlink('/var/www/html/sirge3/storage/swap/puco.txt');

		$sys = "cd /var/www/html/sirge3/storage/swap/; zip -P $password PUCO_" .date("Y-m").".zip PUCO_".date('Y-m').".txt";

        Log::info("genero puco zip");
		exec($sys);

        Log::info("actualiza puco");
		$this->actualizarPuco($password, $this->getBeneficiarios(date('Ym')));

        Log::info("actualizo puco");
        Log::info("notifica");
		$this->notificar($this->getBeneficiarios(date('Ym')), $password);

        Log::info("generar zip");

		$this->generarZipACE();

        Log::info("ejecuta store os beneficiarios sss");
		DB::statement("	SELECT puco.store_os_beneficiarios_sss(); ");
	}

	/**
	 * Genera el zip para mandar al ACE
	 *
	 * @return null
	 */
	public function generarZipACE() {

		$zip = new ZipArchive;

		$res = $zip->open('/var/www/html/sirge3/storage/swap/OSP-SSS-PROFE_'.date('Y-m').'.zip', ZipArchive::CREATE|ZIPARCHIVE::OVERWRITE);

		if ($res === true) {
			$p = Proceso::join('sistema.lotes', 'sistema.lotes.lote', '=', 'puco.procesos_obras_sociales.lote')
				->join('sistema.subidas', 'sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
				->join('sistema.subidas_osp', 'sistema.subidas_osp.id_subida', '=', 'sistema.subidas.id_subida')
				->select('puco.procesos_obras_sociales.*', 'sistema.subidas_osp.*', 'sistema.subidas.nombre_actual', 'sistema.subidas.id_padron', 'sistema.subidas.nombre_original')
				->where('periodo', date('Ym'))
				->get();

			foreach ($p as $obra_social) {
				$zip->addFile($this->getName($obra_social->id_padron, true).'/'.$obra_social->nombre_actual, ($obra_social->id_padron == 6?$obra_social->codigo_osp."_".$obra_social->nombre_original:$obra_social->codigo_osp).'.txt');
			}
			$zip->close();

			$sys = "chmod 666 /var/www/html/sirge3/storage/swap/OSP-SSS-PROFE_".date('Y-m').".zip";
			exec($sys);
		}
	}

	/**
	 * Devuelve la vista de consultas
	 *
	 * @return null
	 */
	public function getConsulta() {
		$data = [
			'page_title' => 'Búsqueda de personas en PUCO'
		];
		return view('puco.consultas', $data);
	}

	/**
	 * Devuelve la ruta donde guardar el archivo
	 * @param int $id
	 *
	 * @return string
	 */
	private function getName($id, $route = false) {

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
			default:
				break;
		}
		if ($route) {
			return '../storage/uploads/'.$p;
		} else {
			return $p;
		}
	}

	/**
	 * Consolidado DOIU 9
	 *
	 * @return null
	 */
	public function reportesEnPeriodo() {

		$dt = new \DateTime();

		for ($i = 0; $i < 1; $i++) {
			$p = $dt->format('Y-m');

			$meses[$i]['periodo'] = $p;
			$meses[$i]['class']   = $i;

			$djs = Provincia::select('sistema.lotes.lote', 'sistema.lotes.id_provincia', 'geo.geojson.geojson_provincia')->
			leftJoin('sistema.subidas_osp', 'sistema.subidas_osp.codigo_osp', '=', 'puco.obras_sociales_provinciales.codigo_osp')
			->leftJoin('sistema.subidas', 'sistema.subidas_osp.id_subida', '=', 'sistema.subidas.id_subida')
			->leftJoin('sistema.lotes', function ($j) {
					$j->on('sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
						->where('sistema.lotes.id_estado', '=', 3);
				})
			/*->leftJoin('puco.procesos_obras_sociales' , function($j){
			$j->on('sistema.lotes.lote' , '=' , 'puco.procesos_obras_sociales.lote');
			})*/
				->leftJoin('puco.obras_sociales', 'puco.obras_sociales_provinciales.codigo_osp', '=', 'puco.obras_sociales.codigo_osp')
				->leftJoin('geo.geojson', 'geo.geojson.id_provincia', '=', 'sistema.lotes.id_provincia')
			//->where('puco.procesos_obras_sociales.periodo' , '=' , date('Ym'))
				->where('sistema.subidas.id_padron', "=", 4)
				->where(DB::raw('extract (year from fin) :: text || lpad (extract (month from fin) :: text, 2 , \'0\')'), '=', date('Ym'))
				->orderBy('id_provincia', 'asc')
				->get();

			$provincia = 1;

			foreach ($djs as $key => $dj) {
				$array_provincias[] = $dj->id_provincia;
			}

			foreach ($djs as $key => $dj) {
				if (in_array($dj->id_provincia, $array_provincias)) {
					$meses[$i]['data'][$key]['value']     = 1;
					$meses[$i]['data'][$key]['provincia'] = $dj->id_provincia;
					$meses[$i]['data'][$key]['hc-key']    = $dj->geojson_provincia;
				} else {
					$meses[$i]['data'][$key]['value']     = 0;
					$meses[$i]['data'][$key]['provincia'] = $dj->id_provincia;
					$meses[$i]['data'][$key]['hc-key']    = $dj->geojson_provincia;
				}
			}

			$meses[$i]['data'] = json_encode($meses[$i]['data']);
			$provincia++;
		}
		unset($provincia);
		unset($array_provincias);
		unset($djs);
		unset($dj);

		return $meses;
	}
}
