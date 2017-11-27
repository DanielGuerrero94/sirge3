<?php

namespace App\Console\Commands;

use App\Http\Controllers\Controller;
use App\Models\Scheduler;
use Auth;
use DB;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class LaravelUpCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sirge:up';

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
        $files = Finder::create()->files()->in(base_path('app/Models'));
        $this->info("Files in models: ".$files->count());
        $counter = 0;

        $key = [];
        $name = [];

        foreach ($files as $file) {
            $content = $file->getContents();
            $hasNameClass = preg_match("/class (\w+)/", $content, $name);
            $name = $hasNameClass?$name[1]:'';
            $hasPrimaryKey = preg_match("/primaryKey = ('\w+');/", $content, $key);
            $key = $hasPrimaryKey?$key[1]:'';

            $isIdLike = preg_match("/id.*/", $key);
            
            if ($hasNameClass && $hasPrimaryKey && !$isIdLike) {
                // $this->warn("Class {$name} has {$key} as primary key.");
                $counter++;

                if ( preg_match("/clave_beneficiario/", $key)) {
                    $this->info("{$name} replace en estas clases.");
                }
            }
        }

        $this->info("Files to change: {$counter}");
    }

    public function FunctionName($value='')
    {
        preg_replace("/(primaryKey.*)/", "$0\n\n\tprotected \$increments = false;", $f);
    }
}
