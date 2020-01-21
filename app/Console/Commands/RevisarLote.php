<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RevisarLote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lote:revisar {lote?} {--list} {--json}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa los rechazos de septiembre a la fecha';

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
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->option('list')) {
            $lotes = \App\Models\Rechazo::first()->toArray(); 
            $this->line($lotes);
            exit();
        }

		$rechazos = \App\Models\Rechazo::where("lote", "=", $this->argument('lote'));
        //$bar = $this->output->createProgressBar($rechazos->count());
        $rechazos = $rechazos->get();
        $counters = [];

		foreach ($rechazos as $rechazo) {

    		$rechazo = $rechazo->toArray();
            try {
                $motivos = json_decode($rechazo['motivos'], true);
            } catch(Exception $e) {
                dump($rechazo);
            } catch(ErrorException $e) {
                dump($rechazo);
            }

            if (!is_array($motivos)) {
                dump($motivos);
                continue;
            }

            $key = array_keys($motivos)[0];

            if (!array_key_exists($key, $counters)) {
                $counters[$key] = 0;
            }

    		$counters[$key]++;
            //$bar->advance();

        }

        //$bar->finish();
        if ($counters != []) {
            if ($this->option('json')) {
                dump(json_encode($counters));
                exit();
            }
            $headers = ['Campo', 'Cantidad'];
            $rows = [];

            array_walk($counters, function ($value, $key) use (&$rows) {
                $rows[] = [$key, $value];
            });

            $this->table($headers, $rows);
        }
    }
}
