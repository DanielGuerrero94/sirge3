<?php

namespace App\Console\Commands;

use DB;
use Auth;
use App\Models\Scheduler;
use App\Models\Subida;
use Illuminate\Console\Command;

use App\Http\Controllers\Controller;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

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
        //app('App\Http\Controllers\DatawarehouseController')->ejecutarTodas();
        //app('App\Http\Controllers\LotesController')->alertSubidasMalProcesadas();        
        //app('App\Http\Controllers\DatawarehouseController')->ejecutarTodas();        
        app('App\Http\Controllers\WebServicesController')->cruzarBeneficiariosConSiisa();
        //DB::table('test')->insert(['mensaje' => 'Hola cómo te va JAVIER MINSKY?, sos bastante gay!']);
    }
}
