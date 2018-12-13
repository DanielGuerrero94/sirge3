<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = "test:run";

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Command description";

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		//app("App\Http\Controllers\WebServicesController")->georeferenciarBeneficiarios();
		//app("App\Http\Controllers\OspController")->procesarArchivo(12809);
		//app("App\Http\Controllers\DatawarehouseController")->ejecutarTodas();
		//app("App\Http\Controllers\LotesController")->alertSubidasMalProcesadas();
		//app("App\Http\Controllers\DatawarehouseController")->ejecutarTodas();
		//app("App\Http\Controllers\LotesController")->eliminarArchivosAntiguos();
		//app("App\Http\Controllers\WebServicesController")->cruzarBeneficiariosConSiisa();
		//app("App\Http\Controllers\RechazosController")->generarRechazosLotesNuevos();
		app("App\Http\Controllers\EfectoresController")->refrescarTabla();
		app("App\Http\Controllers\EfectoresController")->generarTabla();

		/*
		$all = DW_FC001::get();
		foreach ($all as $object) {
		$collection_push               = new FC001();
		$collection_push->id           = $object->id;
		$collection_push->periodo      = $object->periodo;
		$collection_push->id_provincia = $object->id_provincia;
		$collection_push->cantidad     = $object->cantidad;
		$collection_push->monto        = $object->monto;
		$collection_push->save();
		}
		$collection = FC001::get();
		 */

		/*
		$all = DW_FC005::get();

		foreach ($all as $object) {
		$collection_push                    = new FC005();
		$collection_push->id                = $object->id;
		$collection_push->periodo           = $object->periodo;
		$collection_push->id_provincia      = $object->id_provincia;
		$collection_push->codigo_prestacion = $object->codigo_prestacion;
		$collection_push->grupo_etario      = $object->grupo_etario;
		$collection_push->sexo              = $object->sexo;
		$collection_push->cantidad          = $object->cantidad;
		$collection_push->save();
		}
		echo FC005::count();

		 */

		/*

		$collect = FC005::raw(function ($collection) {
		return $collection->aggregate([
		["$match" => ["id_provincia" => "05"]],
		["$limit" => 20]
		//["$group" => ["_id" => "$sexo", "cantidad" => ["$sum" => "$cantidad"]]]
		]);
		});

		echo json_encode($collect->all(), JSON_PRETTY_PRINT);

		 */

		/*
		$log               = new LogAcciones();
		$log->id_provincia = "05";
		$log->id_usuario   = 191;
		$log->accion       = json_encode(array("accion" => "Modificacion del Numerador o Denominador del indicador", "estado_anterior" => array("numerador" => "100", "denominador" => "150"), "estado_actual" => array("numerador" => "120", "denominador" => "130")));
		$log->save();

		$log               = new LogAcciones();
		$log->id_provincia = "04";
		$log->id_usuario   = 191;
		$log->accion       = json_encode(array("accion" => "Descarga de excel de indicadores cargados en periodo "."2018-03", "estado_anterior" => NULL, "estado_actual" => NULL));
		$log->save();

		$log               = new LogAcciones();
		$log->id_provincia = "21";
		$log->id_usuario   = 53;
		$log->accion       = json_encode(array("accion" => "Descarga de excel de administracion en periodo "."2018-03"." provincia "."21", "estado_anterior" => NULL, "estado_actual" => NULL));
		$log->save();
		 */

		/*
	$stream = fopen('/var/www/html/sirge3/calles.json', 'r');
	$object = json_decode(stream_get_contents($stream, -1, 0));

	$i = 0;

	try {
	foreach ($object->datos as $row) {
	$calle               = new Calles();
	$calle->nomenclatura = $row->nomenclatura;
	$calle->id           = $row->id;
	$calle->nombre       = $row->nombre;
	$calle->tipo         = $row->tipo;
	$calle->altura       = json_encode(array("inicio" => json_encode((array) $row->altura->inicio), "fin" => json_encode((array) $row->altura->fin)));
	$calle->geometria    = $row->geometria;
	$calle->departamento = json_encode(["id" => $row->departamento->id, "nombre" => $row->departamento->nombre]);
	$calle->provincia    = json_encode(["id" => $row->provincia->id, "nombre" => $row->provincia->nombre]);

	$calle->save();
	unset($calle);
	}

	} catch (Exception $e) {
	var_dump($row);
	}
	 */

	}
}
