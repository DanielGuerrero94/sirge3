<?php

namespace App\Console\Commands;

use App\Models\Subida;
use Auth;
use Log;
use Illuminate\Console\Command;

class CommandScheduler extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	//protected $signature = 'scheduler:execute {periodo}';
	protected $signature = 'scheduler:execute';

	/**2
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Al ejecutar scheduler executed desde el Kernel, se inicia el método handle.';

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

		$subidas = Subida::where('id_estado', 1)->orderBy('fecha_subida', 'DESC')->get()->pluck('id_subida')->all();
		$subidas = array_values($subidas);

		while ($subidas) {
			$popped_subida = array_pop($subidas);
			if ($popped_subida) {
				$subida = Subida::find($popped_subida);
				if ($subida->id_estado != 5) {
					$subida->id_estado = 5;
					$subida->save();
					if (!Auth::check()) {
						Auth::loginUsingId($subida->id_usuario, true);
					}
					try {
						switch ($subida->id_padron) {
							case 1:
								app('App\Http\Controllers\PrestacionesController')->procesarArchivo($subida->id_subida);
								break;
							case 2:
								app('App\Http\Controllers\FondosController')->procesarArchivo($subida->id_subida);
								break;
							case 3:
								app('App\Http\Controllers\ComprobantesController')->procesarArchivo($subida->id_subida);
								break;
							case 4:
								app('App\Http\Controllers\OspController')->procesarArchivo($subida->id_subida);
								break;
							case 5:
								app('App\Http\Controllers\ProfeController')->procesarArchivo($subida->id_subida);
								break;
							case 6:
								app('App\Http\Controllers\SuperController')->procesarArchivo($subida->id_subida);
								break;
							case 7:
								app('App\Http\Controllers\TrazadorasController')->procesarArchivo($subida->id_subida);
								break;
							case 8:
								app('App\Http\Controllers\TableroController')->procesarArchivo($subida->id_subida);
								break;
							case 10:
								$result = app('App\Http\Controllers\PrestacionesDoiFacturadasController')->procesarArchivo($subida->id_subida);
								var_dump($result->getContent());
								break;
							case 11:
								app('App\Http\Controllers\PrestacionesDoiLiquidadasController')->procesarArchivo($subida->id_subida);
								break;
							case 12:
								app('App\Http\Controllers\PrestacionesDoiPagadasController')->procesarArchivo($subida->id_subida);
								break;
							default:
								break;
						}
						Auth::logout();
						Subida::where('id_subida', $subida->id_subida)->update(['id_estado' => 3]);
					} catch (Exception $e) {
						return json_encode($e->getMessage());
					}
				}
			}
		}
	}
}
