<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

use App\Models\PUCO\Provincia;

class Diff extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diff';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'diff';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $puco = new \App\Http\Controllers\PucoController();
        //$results = $puco->reportesEnPeriodo();
        //$result = $puco->generar();
        $result = $puco->generarZipACE();
        /*
 $datos = Provincia::leftJoin('sistema.subidas_osp', 'sistema.subidas_osp.codigo_osp', '=', 'puco.obras_sociales_provinciales.codigo_osp')
            ->leftJoin('sistema.subidas', 'sistema.subidas_osp.id_subida', '=', 'sistema.subidas.id_subida')
            ->leftJoin('sistema.lotes', function ($j) {
                $j->on('sistema.subidas.id_subida', '=', 'sistema.lotes.id_subida')
                    ->where('sistema.lotes.id_estado', '=', 3);
            })
            ->leftJoin('puco.procesos_obras_sociales', function ($j) {
                $j->on('sistema.lotes.lote', '=', 'puco.procesos_obras_sociales.lote');
            })->leftJoin('puco.obras_sociales', 'puco.obras_sociales_provinciales.codigo_osp', '=', 'puco.obras_sociales.codigo_osp')
           ->where('puco.procesos_obras_sociales.periodo', '=', date('Ym'))
           ->get();
         */
        //dump($datos);

        //$result = $puco->getBeneficiarios("201903");
        /*
        foreach($results as $result) {
            dump($result);
        }
         */
    }
}
