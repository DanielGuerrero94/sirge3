<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use Storage;

class DatosReportablesToCsvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dr:csv {lote}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Devuelve Csv de un periodo, lote o provincia';

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
        $lote = $this->argument('lote');
        DB::select("Copy (SELECT r.lote ,r.validos, r.ausentes, r.errores, p.codigo_prestacion, p.datos_reportables, age(p.fecha_prestacion, b.fecha_nacimiento), p.* from logs.revision r join sistema.lotes l on l.lote = r.lote join prestaciones.prestaciones p on p.id = r.id_prestacion join beneficiarios.beneficiarios b on b.clave_beneficiario = p.clave_beneficiario where l.lote = {$lote}) to '/tmp/dr/{$lote}.csv' delimiter ';' csv header");
        $this->call("get:file", ['name' => "{$lote}.csv"]);
        Storage::disk('local')->put("/dr/a", 'test');
    }
}
