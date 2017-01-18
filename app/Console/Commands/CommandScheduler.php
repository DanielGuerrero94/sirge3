<?php

namespace App\Console\Commands;

use DB;
use App\Models\Scheduler;
use Illuminate\Console\Command;

use App\Http\Controllers\Controller;

class CommandScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'scheduler:execute {periodo}';
    protected $signature = 'scheduler:execute';

    /**
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
        /*$schedule = new Scheduler;
        
        $schedule->contexto = 'Probando el Scheduler';
        $schedule->estado = 0;
        $schedule->periodo = $this->argument('periodo');        

        $schedule->save();*/
        //RechazosController::generarRechazosLote();
        app('App\Http\Controllers\RechazosController')->generarRechazosLotesNuevos();
        app('App\Http\Controllers\WebServicesController')->cruzarBeneficiariosConSiisa();
        //app('App\Http\Controllers\PrestacionesController')->corregirDatosReportables();
    }
}
