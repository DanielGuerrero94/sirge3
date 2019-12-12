<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RechazarLoteCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = "lote:rechazar {id}";

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Rechazar lote";

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		$request = request();
		$request->lote = $this->argument('id');
		$respuesta = app("App\Http\Controllers\LotesController")->eliminarLote($request);
		$respuesta = property_exists($respuesta, 'statusCode')?$respuesta->content():$respuesta;
		dump($respuesta); 
	}

}
