<?php

namespace App\Console;

use DB;
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

        //$schedule->command('scheduler:execute',[$periodo_a_automatizar])->everyMinute()->sendOutputTo('/home/vnc/log_scheduler.txt');        
        $periodo_a_automatizar = Scheduler::select(DB::raw('max(periodo)'))->where('estado',1)->first()->max;        

        $schedule->call('App\Http\Controllers\DatawarehouseController@ejecutarTodas', [$periodo_a_automatizar])->everyMinute()
        ->when(function () {                    
            
                    

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

            })->sendOutputTo('/home/vnc/log_scheduler.txt');
        //$schedule->call('App\Http\Controllers\HomeController@test', ['Rodrigo'])->everyMinute();

        /*$schedule->call(function ($periodo_a_automatizar) {            


        },$data)->everyMinute()->when(function () {                    
            
                    $periodo_actual = date('Ym');
                    $dt = \DateTime::createFromFormat('Ym' , $periodo_actual);        
                    $dt->modify('-1 month');
                    $periodo_a_automatizar = $dt->format('Ym');

                    $row = Scheduler::select('estado')
                                ->where('contexto','migracion_beneficiarios')
                                ->where('periodo',$periodo_a_automatizar)
                                ->get();

                    $estado = $row[0]->estado;
                    
                    if($estado == 0){
                        return true;
                    }
                    else{
                        return false;
                    }

            })->sendOutputTo('/home/vnc/log_scheduler.txt');*/

    }
}
