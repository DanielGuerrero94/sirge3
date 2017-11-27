<?php

namespace App\Console\Commands;

use DB;
use Auth;
use App\Models\Scheduler;
use App\Models\Subida;
use Illuminate\Console\Command;

use App\Http\Controllers\Controller;

class CommandScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:execute {--periodo= : Especifica un periodo(TODO)}';

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
        
        $subidas = Subida::where('id_estado', 1)->orderBy('fecha_subida', 'DESC')->pluck('id_subida')->all();
        $subidas = array_values($subidas);

        while ($subidas) {
            $popped_subida = array_pop($subidas);
            if ($popped_subida) {
                $subida = Subida::find($popped_subida);
                if ($subida->id_estado != 5) {
                    $subida->id_estado = 5;
                    $subida->save();
                    if (!Auth::check()) {
                        Auth::loginUsingId($subida->id_usuario, true);
                    }
                    try {
                        switch ($subida->id_padron) {
                            case 1:
                                app('App\Http\Controllers\PrestacionesController')->procesarArchivo($subida->id_subida);
                                break;
                            case 2:
                                app('App\Http\Controllers\FondosController')->procesarArchivo($subida->id_subida);
                                break;
                            case 3:
                                app('App\Http\Controllers\ComprobantesController')->procesarArchivo($subida->id_subida);
                                break;
                            case 4:
                                app('App\Http\Controllers\OspController')->procesarArchivo($subida->id_subida);
                                break;
                            case 5:
                                app('App\Http\Controllers\ProfeController')->procesarArchivo($subida->id_subida);
                                break;
                            case 6:
                                app('App\Http\Controllers\SuperController')->procesarArchivo($subida->id_subida);
                                break;
                            case 7:
                                app('App\Http\Controllers\TrazadorasController')->procesarArchivo($subida->id_subida);
                                break;
                        }
                        Auth::logout();
                        Subida::where('id_subida', $subida->id_subida)->update(['id_estado' => 3]);
                    } catch (Exception $e) {
                        return json_encode($e->getMessage());
                    }
                }
            }
        }
    }
}
