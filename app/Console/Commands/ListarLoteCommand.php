<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class ListarLoteCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = "lote:listar {padron=1} {estado=1}";

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Lista los lostes de un padron y su estado, default prestaciones pendientes
  id_padron | padron
  ----------+-------------------
          1 | PRESTACIONES
	    2 | FONDOS
          3 | COMPROBANTES
	    4 | OSP
	    5 | PROFE
	    6 | SSS
	    7 | TRAZADORAS
	    8 | TABLERO DE CONTROL
	    9 | VPH Y PAP

  id_estado | estado
  ----------+------------
	    1 | PENDIENTE
	    2 | EN REVISION
	    3 | ACEPTADO
	    4 | ELIMINADO
	    5 | PROCESANDO
";

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
	$query = "select * from v_estado_lotes where id_estado = " . $this->argument('estado') . " and id_padron = " . $this->argument('padron');
        $pendientes = DB::select($query);
        dump($pendientes);
	}

}
