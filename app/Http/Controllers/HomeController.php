<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Dw\AfRubro;

use App\Models\Dw\CEB\Ceb002;
use App\Models\Dw\FC\Fc001;
use App\Models\Dw\IndecPoblacionPais as Indec;

use App\Models\Efector;
use App\Models\Lote;
use App\Models\Modulo;
use App\Models\ModuloMenu;

use App\Models\Usuario;

use Auth;
use DB;
use Illuminate\Http\Request;
use Mail;
use Log;

class HomeController extends Controller {

	public function test($nombre) {
		DB::table('test')->insert(['mensaje' => 'Hola cómo te va '.$nombre.'?, sos bastante gay!']);
	}

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
	 * Vista principal en caso de no ingresar login o inicio
	 *
	 * @return null
	 */
	public function index() {
        return redirect()->intended('inicio');
	}

	/**
	 * Armado de menú
	 * @param int $id_menu
	 *
	 * @return array
	 */
	public function getMenu($id_menu) {
		$menu       = array();
		$relaciones = ModuloMenu::join('sistema.modulos', 'sistema.modulos_menu.id_modulo', '=', 'sistema.modulos.id_modulo')
			->where('id_menu', $id_menu)
			->orderBy('nivel_1')
			->orderBy('nivel_2');

            Log::debug($relaciones->toSql());
        $relaciones = $relaciones->get();

		foreach ($relaciones as $key => $relacion) {
			$modulo                                  = Modulo::find($relacion->id_modulo);
			$menu[$modulo->id_modulo]['descripcion'] = $modulo->descripcion;
			$menu[$modulo->id_modulo]['modulo']      = $modulo->modulo;
			$menu[$modulo->id_modulo]['nivel_1']     = $modulo->nivel_1;
			$menu[$modulo->id_modulo]['nivel_2']     = $modulo->nivel_2;
			$menu[$modulo->id_modulo]['icono']       = $modulo->icono;
			$menu[$modulo->id_modulo]['arbol']       = $modulo->arbol;
			$menu[$modulo->id_modulo]['id_padre']    = $modulo->id_padre;
			$menu[$modulo->id_modulo]['hijos']       = [];
		}
		return $this->armaArbol($menu);
	}

	/**
	 * Armo árbol con módulos
	 * @param array $menu
	 *
	 * @return string
	 */
	public function armaArbol($menu) {
		foreach ($menu as $key => $modulo) {
			if ($modulo['id_padre']) {
				$index = $modulo['id_padre'];
				array_push($menu[$index]['hijos'], $modulo);
				unset($menu[$key]);
			}
		}
		return $menu;
	}

	/**
	 * Retorna vista principal
	 *
	 * @return null
	 */
	public function inicio() {

        $id_menu = Auth::user()->id_menu;
        /*   
        if ($id_menu == 22) {
            return redirect()->intended('telesalud');
        }
         */
		$data = [
			'usuario'   => Auth::user()->nombre,
			'ocupacion' => Auth::user()->ocupacion,
			'mensaje'   => Auth::user()->mensaje,
			'modulos'   => $this->getMenu($id_menu)
		];

		return view('inicio', $data);
	}

	/**
	 * Devuelve el rango de periodos a filtrar
	 *
	 * @return array
	 */
	public function getDateInterval() {

		$dt = new \DateTime();
		$dt->modify('-1 month');
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
	public function getProgresoCeb() {

		$interval = $this->getDateInterval();

		$periodos = Ceb002::select('periodo', DB::raw('sum(beneficiarios_activos) as b'), DB::raw('sum(beneficiarios_ceb) as c'))
			->whereBetween('periodo', [$interval['min'], $interval['max']])
			->groupBy('periodo')
			->orderBy('periodo')
			->get();

		foreach ($periodos as $key => $periodo) {
			$chart[0]['name']       = 'Benef. CEB';
			$chart[0]['data'][$key] = $periodo->c;

			$chart[1]['name']       = 'Benef. ACT';
			$chart[1]['data'][$key] = $periodo->b;
		}
		return json_encode($chart);
	}

	/**
	 * Devuelve la info para generar un gráfico
	 *
	 * @return json
	 */
	public function getProgresoFc() {

		$interval = $this->getDateInterval();

		$periodos = Fc001::select('periodo', DB::raw('sum(cantidad) as cf'), DB::raw('sum(monto) as mf'))
			->whereBetween('periodo', [$interval['min'], $interval['max']])
			->groupBy('periodo')
			->orderBy('periodo')
			->get();
		foreach ($periodos as $key => $periodo) {
			$chart[0]['name']              = 'Prest. fact.';
			$chart[0]['data'][$key]        = $periodo->cf;
			$chart[0]['marker']['enabled'] = false;

			/*
		$chart[1]['name'] = 'Monto. fact.';
		$chart[1]['data'][$key] = (float)$periodo->mf/100;
		 */
		}
		return json_encode($chart);
	}

	/**
	 * Devuelve la info para generar un gráfico
	 *
	 * @return json
	 */
	public function getFondosAll() {

		$fondos = AfRubro::join('estadisticas.uf_001', 'af_rubros.rubro', '=', 'estadisticas.uf_001.rubro')
			->select('af_rubros.nombre as name', DB::raw('sum(monto)::bigint as y'))
			->groupBy('af_rubros.nombre')
			->get();

		return json_encode($fondos);
	}

	/**
	 * Devuelve listado de 6 meses
	 *
	 * @return json
	 */
	public function getMesesArray() {

		$dt = new \DateTime();
		$dt->modify('-13 months');
		for ($i = 0; $i < 12; $i++) {
			$dt->modify('+1 month');

			$meses[$i] = strftime("%b", $dt->getTimeStamp());
		}
		return json_encode($meses);
	}

	/**
	 * Devuelve la cantidad total de prestaciones facturadas
	 *
	 * @return string
	 */
	public function getPrestacionesFacturadas() {
		$ps = Fc001::sum('cantidad');
		return round($ps/1000000, 2).'M';
	}

	/**
	 * Devuelve la cantidad de efectores activos
	 *
	 * @return int
	 */
	public function getEfectores() {
		return Efector::where('id_estado', 1)->count();
	}

	/**
	 * Devuelve el número de usuarios
	 *
	 * @return int
	 */
	public function getUsuarios() {
		return Usuario::where('activo', 'S')->count();
	}

	/**
	 * Devuelve el número de beneficiarios que pasaron por el programa
	 *
	 * @return int
	 */
	public function getBeneficiariosTotal() {
		$periodo = Ceb002::select(DB::raw('max(periodo)'))->first()->max;
		return round(Ceb002::where('periodo', $periodo)->sum('beneficiarios_registrados')/1000000, 2);
	}

	/**
	 * Devuelve el número de registros ingresados
	 * @param int $id
	 *
	 * @return int
	 */
	public function getRegistrosIn($id) {

		$dt = new \DateTime();
		$dt->modify('first day of this month');
		$min = $dt->format('Y-m-d');
		$dt->modify('last day of this month');
		$max = $dt->format('Y-m-d');

		if ($id <> 4) {
			return Lote::join('sistema.subidas', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
				->where('id_padron', $id)
				->where('sistema.lotes.id_estado', 3)
				->whereBetween('fin', [$min, $max])
				->sum('registros_in');
		} elseif ($id == 4) {
			return Lote::join('sistema.subidas', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
				->whereIn('id_padron', [4, 5, 6])
				->where('sistema.lotes.id_estado', 3)
				->whereBetween('fin', [$min, $max])
				->sum('registros_in');
		}
	}

	/**
	 * Devuelve el porcentaje de cumplimiento
	 * @param int $id
	 *
	 * @return int
	 */
	public function getPorcentajeIn($id) {
		$dt = new \DateTime();
		$dt->modify('first day of this month');
		$min = $dt->format('Y-m-d');
		$dt->modify('last day of this month');
		$max = $dt->format('Y-m-d');
		if ($id <> 4) {
			$lotes = Lote::join('sistema.subidas', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
				->where('id_padron', $id)
				->where('sistema.lotes.id_estado', 3)
				->whereBetween('fin', [$min, $max])
				->groupBy('sistema.lotes.id_provincia')
				->select('sistema.lotes.id_provincia')
				->get();
			return round(sizeof($lotes)*100/24, 2);
		} elseif ($id == 4) {
			$lotes = Lote::join('sistema.subidas', 'sistema.lotes.id_subida', '=', 'sistema.subidas.id_subida')
				->whereIn('id_padron', [4, 5, 6])
				->where('sistema.lotes.id_estado', 3)
				->whereBetween('fin', [$min, $max])
			// ->groupBy('sistema.subidas.id_padron')
				->select('sistema.subidas.id_padron')
				->get();
			return round(sizeof($lotes)*100/30, 2);
		}
	}

	/**
	 * Devuelve las visitas
	 *
	 * @return array
	 */
	public function getVisitas() {
		$array = [
			'total'   => 0,
			'visitas' => []
		];

		$visitas = DB::select("
            select * from (
                select
                    extract (year from fecha_login) ::text || lpad (extract (month from fecha_login) :: text , 2 , '0') as c
                    , count(*) as v
                from logs.logins
                group by
                    extract (year from fecha_login) ::text || lpad (extract (month from fecha_login) :: text , 2 , '0')
                order by
                    extract (year from fecha_login) ::text || lpad (extract (month from fecha_login) :: text , 2 , '0')
                limit 6
            ) a order by c desc");
		foreach ($visitas as $visita) {
			$array['visitas'][] = $visita->v;
			$array['total'] += $visita->v;
		}
		return $array;
	}

	/**
	 * Devuelve efectores dados de alta
	 *
	 * @return array
	 */
	public function getAltasEfectores() {
		$array = [
			'total' => 0,
			'altas' => []
		];

		$altas = DB::select("
            select * from (
                select
                    extract (year from created_at) ::text || lpad (extract (month from created_at) :: text , 2 , '0') as c
                    , count(*) as v
                from efectores.efectores
                group by
                    extract (year from created_at) ::text || lpad (extract (month from created_at) :: text , 2 , '0')
                order by
                    extract (year from created_at) ::text || lpad (extract (month from created_at) :: text , 2 , '0')
                limit 6
                ) a order by c desc");
		foreach ($altas as $alta) {
			$array['altas'][] = $alta->v;
			$array['total'] += $alta->v;
		}
		return $array;
	}

	/**
	 * Devuelve la cantidad de usuarios dados de alta
	 *
	 * @return array
	 */
	public function getAltasUsuarios() {
		$array = [
			'total' => 0,
			'altas' => []
		];

		$altas = DB::select("
            select * from (
                select
                    extract (year from created_at) ::text || lpad (extract (month from created_at) :: text , 2 , '0') as c
                    , count(*) as v
                from sistema.usuarios
                group by
                    extract (year from created_at) ::text || lpad (extract (month from created_at) :: text , 2 , '0')
                order by
                    extract (year from created_at) ::text || lpad (extract (month from created_at) :: text , 2 , '0')
                limit 6
                ) a order by c desc");
		foreach ($altas as $alta) {
			$array['altas'][] = $alta->v;
			$array['total'] += $alta->v;
		}
		return $array;
	}

	/**
	 * Devuelve la info para poblar el mapa
	 *
	 * @return json
	 */
	public function getDataMap() {
		$periodo = Ceb002::select(DB::raw('max(periodo)'))->first()->max;

		$provincias = Indec::leftJoin('geo.geojson', 'indec.poblacion.id_provincia', '=', 'geo.geojson.id_provincia')
			->leftJoin('estadisticas.ceb_002', function ($q) use ($periodo) {
				$q->on('geo.geojson.id_provincia', '=', 'estadisticas.ceb_002.id_provincia')
					->where('periodo', '=', $periodo);
			})->get();

		foreach ($provincias as $key => $provincia) {
			$map[$key]['hc-key']     = $provincia->codigo;
			$map[$key]['value']      = $provincia->habitantes;
			$map[$key]['inscriptos'] = $provincia->beneficiarios_registrados;
			$map[$key]['activos']    = $provincia->beneficiarios_activos;
			$map[$key]['ceb']        = $provincia->beneficiarios_ceb;
		}

		return json_encode($map);
	}

	/**
	 * Retorna vista dashboard
	 *
	 * @return null
	 */
	public function dashboard() {
        $id_menu = Auth::user()->id_menu;
        if ($id_menu == 22) {
            return redirect()->action('TelesaludController@mainForm');
        }

		$visitas   = $this->getVisitas();
		$efectores = $this->getAltasEfectores();
		$usuarios  = $this->getAltasUsuarios();

		$data = [
			'page_title'              => 'Dashboard',
			'grafico_ceb'             => $this->getProgresoCeb(),
			'grafico_fc'              => $this->getProgresoFc(),
			'grafico_af'              => $this->getFondosAll(),
			'meses'                   => $this->getMesesArray(),
			'total_prestaciones'      => $this->getPrestacionesFacturadas(),
			'total_efectores'         => $this->getEfectores(),
			'total_usuarios'          => $this->getUsuarios(),
			'total_beneficiarios'     => $this->getBeneficiariosTotal().'M',
			'mes_prestaciones'        => $this->getRegistrosIn(1),
			'porcentaje_prestaciones' => $this->getPorcentajeIn(1),
			'mes_comprobantes'        => $this->getRegistrosIn(3),
			'porcentaje_comprobantes' => $this->getPorcentajeIn(3),
			'mes_fondos'              => $this->getRegistrosIn(2),
			'porcentaje_fondos'       => $this->getPorcentajeIn(2),
			'mes_puco'                => $this->getRegistrosIn(4),
			'porcentaje_puco'         => $this->getPorcentajeIn(4),
			'mes'                     => ucwords(strftime("%B %Y")),
			'visitas'                 => implode(',', $visitas['visitas']),
			'visitas_total'           => $visitas['total'],
			'efectores'               => implode(',', $efectores['altas']),
			'efectores_total'         => $efectores['total'],
			'usuarios'                => implode(',', $usuarios['altas']),
			'usuarios_total'          => $usuarios['total'],
			'map'                     => $this->getDataMap()
		];
		return view('dashboard', $data);
	}

	/**
	 * Devuelve la vista de Acerca Nuestro
	 *
	 * @return null
	 */
	public function about() {

		$sistemas = Usuario::where('id_area', 1)->where('id_entidad', 1)->where('activo', 'S')->where('usuario', '<>', 'administrador')->orderBy('id_usuario')->get();
		$data     = [
			'page_title' => 'Acerca nuestro',
			'usuarios'   => $sistemas
		];
		return view('about-us', $data);

	}

	/**
	 * Devuelve la vista de contacto
	 *
	 * @return null
	 */
	public function getContacto() {
		$data = [
			'page_title' => 'Contacto'
		];
		return view('contact', $data);
	}

	/**
	 * Envia el email de contacto
	 * @param Request $r
	 *
	 * @return string
	 */
	public function postContacto(Request $r) {

		$user = Auth::user();
		$html = $r->cuerpo."\n".$r->nombre;
		Mail::raw($html, function ($m) use ($user, $r) {
				$m->from('sirgeweb@gmail.com');
				$m->to('sistemasuec@gmail.com');
				$m->to('gustavo.hekel@gmail.com');
				$m->to('sirgeweb@gmail.com');
				$m->replyTo($r->email);
				$m->subject('Email de contacto SIRG3 Web');
			});

		return 'Mensaje enviado';

	}
}
