<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class LoteCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = "lote:listar";

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Lista los lotes y su estado, muestra por default pendientes";

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
        $this->pendientes();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function pendientes() {
        $pendientes = DB::select('select * from v_estado_lotes where id_estado = 1');
        dump($pendientes);
	}

}
