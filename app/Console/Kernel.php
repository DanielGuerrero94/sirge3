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
        \App\Console\Commands\CommandScheduler::class,
        \App\Console\Commands\TestCommand::class
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
        
        $schedule->call('App\Http\Controllers\EfectoresController@generarTabla')->dailyAt('21:30');
        $schedule->call('App\Http\Controllers\PssController@generarTabla')->dailyAt('22:00');
        $schedule->call('App\Http\Controllers\RechazosController@generarRechazosLotesNuevos')->hourly();
        $schedule->call('App\Http\Controllers\DatawarehouseController@ejecutarTodas')->cron('35 16 31 * * *');
                
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:02');        
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:05');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:08');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:25');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('20:31');            

        //BORRO LA TABLA DE TEMPORALES
        $schedule->call('App\Http\Controllers\WebServicesController@borrarTablaTemporal')->dailyAt('23:55');
        $schedule->call('App\Http\Controllers\WebServicesController@borrarTablaTemporal')->dailyAt('05:55');
        
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:26');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:30');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:36');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:40');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:44');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:48');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:52');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('00:56');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('01:00');
        $schedule->call('App\Http\Controllers\WebServicesController@cruzarBeneficiariosConSiisa')->dailyAt('01:04');        

        $schedule->command('scheduler:execute')->cron('* * * * * *');
        $schedule->call('App\Http\Controllers\LotesController@alertSubidasMalProcesadas')->dailyAt('04:00');
        $schedule->call('App\Http\Controllers\LotesController@alertLotesPendientes')->dailyAt('03:00');
        
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
