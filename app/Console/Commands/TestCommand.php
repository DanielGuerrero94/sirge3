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
	protected $description = "Corre el refresh de la materialized view y genera el excel/zip para el listado de efectores";

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
		app("App\Http\Controllers\EfectoresController")->refrescarTabla();
		app("App\Http\Controllers\EfectoresController")->generarTabla();
	}
}
