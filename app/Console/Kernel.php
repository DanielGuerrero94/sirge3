<?php

namespace App\Console;

use DB;
use App\Http\Controllers\Controller;
use App\Models\Scheduler;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\CommandScheduler::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {                    
        //$schedule->call('App\Http\Controllers\HomeController@test', ['Alejandro'])->everyMinute();
        
        $periodo_a_automatizar = Scheduler::select(DB::raw('max(periodo)'))->where('estado',1)->first()->max;
        
        /*$schedule->call('App\Http\Controllers\EfectoresController@generarTabla')->dailyAt('21:30');
        $schedule->call('App\Http\Controllers\PssController@generarTabla')->dailyAt('22:00');
        $schedule->call('App\Http\Controllers\RechazosController@generarRechazosLotesNuevos')->hourly();
        $schedule->call('App\Http\Controllers\DatawarehouseController@ejecutarTodas')->cron('49 19 31 * * *');*/
        
        //LO QUE SE ESTA EJECUTANDO DESDE EL 48
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:01');        
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:05');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:09');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:13');        

        //BORRO LA TABLA DE TEMPORALES
        $schedule->call('App\Http\Controllers\WebServicesController@borrarTablaTemporal')->dailyAt('23:55');
        $schedule->call('App\Http\Controllers\WebServicesController@borrarTablaTemporal')->dailyAt('05:55');

        //LO QUE SE EJECUTA EN MI LOCALHOST
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:00');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:04');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:08');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:12');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:16');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:20');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:24');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:28');

        //$schedule->command('scheduler:execute',[$periodo_a_automatizar])->everyMinute();
        
       /* ->when(function ($periodo_a_automatizar) {                                                

                    $estado = Scheduler::select('estado')
                                ->where('contexto','migracion_beneficiarios')
                                ->where('periodo',$periodo_a_automatizar)
                                ->first()->estado;                    
                    
                    if($estado == 0){
                        return true;
                    }
                    else{
                        return false;
                    }

        });*/
    }
}
