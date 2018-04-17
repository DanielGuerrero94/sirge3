<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Artisan;
use Illuminate\Database\QueryException;
use App\Models\Dw\DR\ResumenLote;
use DB;
use Log;

class RevisarDatosReportables extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $lote;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($lote)
    {
        $this->lote = $lote;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
	try {
            info("Revisando datos reportables del lote {$this->lote}");
       	    Artisan::call('get:datos-reportables', ['--lote' => $this->lote]);
	} catch (QueryException $e) {
	    Log::warning(json_encode($e->getMessage()));
	} catch (PDOException $e) {
            Log::warning(json_encode($e->getMessage()));
	} finally {
            info("Lote {$this->lote} revisado.");
	    $resumen = DB::connection('datawarehouse')->table('dr.revision_prestaciones')->where('lote', $this->lote)
		->whereRaw("not(validos is null and ausentes is null and errores is null)")
		->selectRaw("count(validos) as validos, count(ausentes) as ausentes, count(errores) as errores")->first();
            $resumen->lote = $this->lote;
            ResumenLote::create((array) $resumen);
            info("Resumen actualizado");
	}
    }
}
