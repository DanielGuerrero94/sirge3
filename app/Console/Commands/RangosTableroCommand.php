<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tablero\Rango;

class RangosTableroCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tablero:rangos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	$rangos = Rango::where('year', 2019)->get();
	foreach($rangos as $rango) {
		$this->info($rango->id_provincia);
		$this->info($rango->indicador);
		dump($rango);
		$new = new Rango();
		$new->id_provincia = $rango->id_provincia;
		$new->year = $rango->year + 1;
		$new->indicador = $rango->indicador;
		$new->yellow = $rango->yellow;
		$new->red = $rango->red;
		$new->green = $rango->green;
		$new->save();
	}

    }
}
