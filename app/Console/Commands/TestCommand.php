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
		//app("App\Http\Controllers\EfectoresController")->refrescarTabla();
		//app("App\Http\Controllers\EfectoresController")->generarTabla();
		$rechazos = \App\Models\Rechazo::where('lote', 19445)->get();
		$code = 0; 
		$clave = 0; 
		$pkey = 0; 

		foreach ($rechazos as $rechazo) {

		$rechazo = $rechazo->toArray();
		$motivos = json_decode($rechazo['motivos']);

		if (property_exists($motivos, 'code') && $motivos->code == '23503' ){
			$code++;
			$registro = json_decode($rechazo['registro']);
			dump($registro->clave_beneficiario);
		
		} else if (property_exists($motivos, 'clave_beneficiario')){
			$clave++;
		
		} else if (property_exists($motivos, 'pkey')) {
			$pkey++;
		}else {
			dump($rechazo);
		}



		
		}

		dump("Code: " . $code);
		dump("Clave: " . $clave);
		dump("pkey: " . $pkey);
		dump($code + $clave + $pkey);
		dump($rechazos->count());

	}
}
