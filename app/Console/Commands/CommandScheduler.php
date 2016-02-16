<?php

namespace App\Console\Commands;

use DB;
use App\Models\Scheduler;
use Illuminate\Console\Command;

class CommandScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:execute {periodo}';

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
        $schedule = new Scheduler;
        
        $schedule->contexto = 'Probando el Scheduler';
        $schedule->estado = 0;
        $schedule->periodo = $this->argument('periodo');        

        $schedule->save();
    }
}
