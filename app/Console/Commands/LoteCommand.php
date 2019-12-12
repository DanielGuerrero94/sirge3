<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LoteCommand extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = "lote:ver {id}";

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Ver lote segun id";

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
	    $this->mostrarLote();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function mostrarLote() {
	$lote = \App\Models\Lote::with('archivo')->where('lote', $this->argument('id'))->first()->toArray();
       	dump($lote);
	}

}
