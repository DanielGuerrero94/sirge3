<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Comprobante;
use App\Models\DDJJ\Sirge as DDJJSirge;
use App\Models\Fondo;
use App\Models\GenerarRechazoLote;

use App\Models\Geo\Provincia;

use App\Models\Lote;
use App\Models\LoteAceptado;

use App\Models\Prestacion;
use App\Models\PUCO\Osp;
use App\Models\PUCO\Profe;
use App\Models\PUCO\Super;
use App\Models\Rechazo;
use App\Models\Subida;
use App\Models\Tablero\Ingreso;
use Auth;
use Artisan;
use Datatables;
use DB;
use Exception;
use Illuminate\Http\Request;
use Mail;
use PDF;

class LotesController extends Controller {

    protected $lote;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Devuelve el listado de lotes
	 *
	 * @return null
	 */
	public function listadoLotes($id) {
		$data = [
			'page_title' => 'Administración de Lotes',
			'id_padron'  => $id,
			'priority'   => Auth::user()->id_entidad
		];
		return view('padrones.admin-lotes', $data);
	}

	/**
	 * Devuelve el json para armar la datatable
	 *
	 * @return json
	 */
	public function listadoLotesTabla($id) {
		$lotes = Lote::with('estado')
			->join('sistema.subidas', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
			->leftJoin('trazadoras.headers', 'sistema.lotes.lote', '=', 'trazadoras.headers.lote')
			->where('id_padron', $id)
			->select('sistema.lotes.*', DB::raw('case trazadoras.headers.detalle when \'S\' then trazadora::text || \' det\' else trazadora::text end as nro_trazadora, provincia as tr_provincia, periodo'));

		if (Auth::user()->id_entidad == 2) {
			$lotes = $lotes->where('id_provincia', Auth::user()->id_provincia);
		}

		$lotes = $lotes->get();

		return Datatables::of($lotes)
			->addColumn('estado_css', function ($lote) {
				return '<span class="label label-'.(($lote->id_estado == 1 && $lote->registros_in == 0 && $lote->registros_out == 0 && $lote->fin == '31/12/1969')?'primary'.'">'.'PROCESANDO':$lote->estado->css.'">'.$lote->estado->descripcion).'</span>';
			})
			->setRowClass(function ($lote) {
				return ($lote->id_estado == 1 && $lote->registros_in == 0 && $lote->registros_out == 0 && $lote->fin == '31/12/1969')?'info':'';
			})
			->addColumn('action', function ($lote) {
				return '<button lote="'.$lote->lote.'" class="view-lote btn btn-info btn-xs"'.(($lote->id_estado == 1 && $lote->registros_in == 0 && $lote->registros_out == 0 && $lote->fin == '31/12/1969')?'disabled':'').'><i class="fa fa-pencil-square-o"></i> Ver lote</button>';
			})
			->make(true);
	}

	/**
	 * Devuelve el detalle del lote seleccionado
	 * @param int $lote
	 *
	 * @return null
	 */
	public function detalleLote($lote) {
		$nro_lote                     = $lote;
		$lote                         = Lote::with(['estado', 'archivo', 'usuario', 'provincia'])->findOrFail($nro_lote);
		$rechazo                      = GenerarRechazoLote::where('lote', $nro_lote)->where('estado', 2)->first();
		$rechazo?$descarga_disponible = true:$descarga_disponible = false;

		$minutos_faltantes = 0;

		if (!isset($rechazo)) {
			if ($lote->registros_out > 50000) {
				$coef_rendimiento = 45;
			} else {
				$coef_rendimiento = 80;
			}

			$minutos_de_procesamiento = round((float) ($lote->registros_out/$coef_rendimiento)/60);
			$minutos_faltantes        = 60-date("i")+($minutos_de_procesamiento == 0?1:$minutos_de_procesamiento);
		}

		$data = [
			'page_title'          => 'Detalle lote '.$lote->lote,
			'descarga_disponible' => $descarga_disponible,
			'minutos_faltantes'   => intval($minutos_faltantes),
			'lote'                => $lote
		];

		return view('padrones.detail-lote', $data);
	}

	/**
	 * Devuelve la ruta donde guardar el archivo
	 * @param int $id
	 *
	 * @return string
	 */
	public function getName($id, $route = false) {
		$padrones = ['','prestaciones', 'fondos', 'comprobantes', 'osp', 'profe', 'sss', 'trazadoras', 'tablero', 'vphypap'];
		try {
			$respuesta = $padrones[$id];
		} catch(Exception $e) {
			$respuesta = '';	
		}

		if ($route) {
			$respuesta = "../storage/uploads/" . $respuesta;
		} 
		return $respuesta;
	}

	/**
	 * Marco el lote como aceptado
	 * @param Request $r
	 *
	 * @return string
	 */
	public function aceptarLote(Request $r) {
		$l            = Lote::with('archivo')->findOrFail($r->lote);
		$l->id_estado = 3;
		if ($l->save()) {
			$la                 = new LoteAceptado;
			$la->lote           = $l->lote;
			$la->id_usuario     = Auth::user()->id_usuario;
			$la->fecha_aceptado = 'now';
			if ($la->save()) {
				return 'Se ha aceptado el lote. Recuerde declararlo para imprimir la DDJJ.';
			}
		}
	}

	/**
	 * Elimina los registros de las tablas
	 * @param int $id
	 *
	 * @return null
	 */
	protected function eliminarRegistros($id, $lote) {
		switch ($id) {
			case 1:
				Prestacion::where('lote', $lote)->delete();
				break;
			case 2:
				Fondo::where('lote', $lote)->delete();
				break;
			case 3:
				Comprobante::where('lote', $lote)->delete();
				break;
			case 4:
				Osp::where('lote', $lote)->delete();
				break;
			case 5:
				Profe::where('lote', $lote)->delete();
				break;
			case 6:
				Super::where('lote', $lote)->delete();
				break;
			case 8:
				Ingreso::where('lote', $lote)->delete();
				break;
			default:
				return null;
		}
	}

	/**
	 * Elimina los registros rechazados del lote
	 * @param int $id
	 *
	 * @return null
	 */
	protected function eliminarRegistrosRechazados($lote) {
		Rechazo::where('lote', $lote)->delete();
	}

	/**
	 * Marco el lote como rechazado
	 * @param Request $r
	 *
	 * @return string
	 */
	public function eliminarLote(Request $r) {
		try {
			$l            = Lote::findOrFail($r->lote);
			$l->id_estado = 4;

			$l->save();
			return 'Se ha rechazado el lote.';
		} catch (Exception $e) {
			return response('Error: '.$e->getMessage(), 404);
		}
	}

	/**
	 * Devuelve la vista de rechazos
	 * @param int $lote
	 *
	 * @return null
	 */
	public function getRechazos($lote) {

		$lote = Lote::findOrFail($lote);

		$data = [
			'page_title' => 'Listado de rechazos lote : '.$lote->lote,
			'lote'       => $lote
		];
		return view('padrones.rechazos', $data);
	}

	/**
	 * Devuelve el json para armar la datatable
	 * @param int $lote
	 *
	 * @return json
	 */
	public function getRechazosTabla($lote) {
		$rechazos = Rechazo::where('lote', $lote)->get();
		return Datatables::of($rechazos)
			->make(true);
	}

	/**
	 * Devuelve el nombre del padron correspondiente
	 * @param int $id
	 *
	 * @return string
	 */
	public function getNombrePadron($id) {
		$padrones = ['', 'PRESTACIONES', 'APLICACIÓN DE FONDOS', 'COMPROBANTES', 'OBRA SOCIAL PROVINCIAL', 'PROGRAMA FEDERAL DE SALUD', 'SUPERINTENDENCIA DE SERVICIOS DE SALUD', 'TRAZADORAS', 'TABLERO DE CONTROL', 'VPH Y PAP'];
		$respuesta = '';

		try {
			$respuesta = $padrones[$id];
		} catch(Exception $e) {}
		return $respuesta;
	}

	/**
	 * Marca los lotes como impresos
	 * @param Request $r
	 *
	 * @return null
	 */
	public function declararLotes(Request $r) {
		$lotes_d = [];
		$resumen = [
			'in'  => 0,
			'out' => 0,
			'mod' => 0
		];

		$user  = Auth::user();
		$lotes = DB::table('sistema.lotes as l')
			->join('sistema.subidas as s', 'l.id_subida', '=', 's.id_subida')
			->join('sistema.lotes_aceptados as a', 'l.lote', '=', 'a.lote')
			->where('s.id_padron', $r->padron)
			->whereNotIn('l.lote', function ($q) {
				$q->select(DB::raw('unnest(lote)'))
					->from('ddjj.sirge');
			})
			->where('l.id_provincia', $user->id_provincia)
			->get();

		foreach ($lotes as $key => $lote) {
			$lotes_d[$key] = $lote->lote;
			$resumen['in'] += $lote->registros_in;
			$resumen['out'] += $lote->registros_out;
			$resumen['mod'] += $lote->registros_mod;
		}
		$param = '{'.implode(',', $lotes_d).'}';

		DB::insert("insert into ddjj.sirge (lote) values (?)", [$param]);
		$id = DB::getPdo()->lastInsertId('ddjj.sirge_id_impresion_seq');

		$data = [
			'lotes'         => $lotes,
			'nombre_padron' => $this->getNombrePadron($r->padron),
			'resumen'       => $resumen,
			'jurisdiccion'  => Provincia::where('id_provincia', $user->id_provincia)->firstOrFail(),
			'ddjj'          => DDJJSirge::findOrFail($id)
		];

		if ($id) {
			$path = base_path().'/storage/pdf/ddjj/sirge/'.$id.'.pdf';
			$pdf  = PDF::loadView('pdf.ddjj.sirge', $data);
			$pdf->save($path);
			Mail::send('emails.ddjj-sirge', ['id' => $id, 'usuario' => $user], function ($m) use ($user, $path, $id) {
					$m->from('sirgeweb@sumar.com.ar', 'SIRGe Web');
					$m->to($user->email);
					$m->subject('DDJJ Nº '.$id);
					$m->attach($path);
				});
		}

		return 'Se ha enviado la DDJJ a su casilla de correo electónico. ('.Auth::user()->email.')';
	}

	/**
	 * Alerta al administrador las subidas que llevan más de 12 horas procesándose referenciadas por el lote.
	 *
	 * @return null
	 */
	public function alertSubidasMalProcesadas() {
		$lotes = Subida::join('sistema.lotes', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
			->select('lote')
			->where('sistema.subidas.id_estado', 5)
			->whereRaw("fecha_subida + interval '12 hours' < now()")
			->lists('lote');

		if (isset($lotes[0])) {
			Mail::send('emails.alert-lotes', ['lotes' => $lotes], function ($m) use ($lotes) {
					$m->from('sirgeweb@sumar.com.ar', 'SIRGe Web');
					$m->to('sirgeweb@gmail.com');
					$m->to('javier.minsky@gmail.com');
				//	$m->to('rodrigo.cadaval.sumar@gmail.com');
					$m->subject('ALERTA LOTES DEMORADOS');
				});
		}

		foreach ($lotes as $lote) {

			$subida = Subida::join('sistema.lotes', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
				->where('sistema.lotes.lote', $lote)	->first();

			switch ($subida->id_padron) {
				case 1:
					Prestacion::where('lote', $lote)->delete();
					break;
				case 2:
					Fondo::where('lote', $lote)->delete();
					break;
				case 3:
					Comprobante::where('lote', $lote)->delete();
					break;
				case 4:
					Osp::where('lote', $lote)->delete();
					break;
				case 5:
					Profe::where('lote', $lote)->delete();
					break;
				case 6:
					Super::where('lote', $lote)->delete();
					break;
				case 8:
					Ingreso::where('lote', $lote)->delete();
					break;
				default:
					return null;
			}
		}

		Subida::join('sistema.lotes', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
			->where('sistema.subidas.id_estado', 5)
			->where('sistema.lotes.id_estado', '<>', 4)
			->whereRaw("fecha_subida + interval '12 hours' < now()")
			->update(['id_estado' => 1]);

		return null;
	}

	/**
	 * Alerta al administrador los lotes pendientes desde hace más de 2 días.
	 *
	 * @return null
	 */
	public function alertLotesPendientes() {
		$lotes = Subida::join('sistema.lotes', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
			->join('sistema.usuarios', 'sistema.lotes.id_usuario', '=', 'sistema.usuarios.id_usuario')
			->select('lote', 'sistema.usuarios.email', 'nombre')
			->where('sistema.subidas.id_estado', 3)
			->where('sistema.lotes.id_estado', 1)
			->whereRaw("fin + interval '35 hours' < now()")
			->get('lote', 'email', 'nombre');

		foreach ($lotes as $lote) {
			echo "Enviando mail a: ".$lote->email." por el lote pendiente ".$lote->lote."\n";
			Mail::send('emails.alert-lotes-pendientes', ['lote' => $lote], function ($m) use ($lote) {
					$m->from('sirgeweb@sumar.com.ar', 'SIRGe Web');
					$m->to('sirgeweb@gmail.com');
					$m->to('javier.minsky@gmail.com');
				//	$m->to('rodrigo.cadaval.sumar@gmail.com');
					$m->to($lote->email);
					$m->subject('ALERTA LOTES PENDIENTES');
				});
		}

		return null;
	}

	/**
	 * Elimina los archivos de padrones que fueron rechazados mayores a 30 días.
	 *
	 * @return null
	 */
	public function eliminarArchivosAntiguos() {

		$subidas = Lote::where('id_estado', 4)->where(DB::raw('EXTRACT(DAY FROM now()-fin)::integer'), '>', 30)->lists('id_subida');

		$archivos = Subida::whereIn('id_subida', $subidas)->select(['id_padron', 'nombre_actual'])->get();

		$count = 0;
		foreach ($archivos as $tupla_padron_nombre) {
			try {
				unlink('/var/www/html/sirge3/storage/uploads/'.$this->getName($tupla_padron_nombre->id_padron).'/'.$tupla_padron_nombre->nombre_actual);
				$count++;
			} catch (\Exception $e) {
				echo $e->getMessage();
			}
		}

		echo "<pre> CANTIDAD: ".$count."</pre>";
		echo "<pre>".json_encode($archivos, JSON_PRETTY_PRINT)."</pre>";
		unset($count);
		unset($archivos);
		unset($subidas);
	}

	/**
     * Cancela a la fuerza el lote cambiando los estados para que corra el trigger.
     * Solo deberia usarse en casos que haya quedado trabado.
	 *
	 * @return null
	 */
    public function cancelarLote(Request $r) {
        $this->lote = Lote::find($r->lote);

        try {
            $this->cancelarSubidaAsociada();
            $this->cancelar();
        } catch(Exception $e){
            echo $e->getMessage();
        }
    }

	/**
     * Chequea que sea correcto cancelarlo.
	 *
	 * @return null
	 */
    public function cancelar() {
        if($this->lote->id_estado != 1) {
            throw new Exception("Para cancelar un lote tiene que estar en el estado procesando");
        }

        $this->id_estado = 4;
        $this->save();
        echo "Lote {$this->lote->lote} cancelado.\n";
    }

	/**
     * Cancela la subida asociada al lote.
	 *
	 * @return null
	 */
	public function cancelarSubidaAsociada() {

        $subida = $this->lote->archivo()->first();

        if($subida->id_estado != 3) {
            throw new Exception("Para cancelar una subida tiene que estar en el estado procesando");
        }

        $this->id_estado = 4;
        $this->save();
        echo "Subida {$subida->id_subida} del padron {$subida->id_padron} cancelado.";
    }

}
