<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class GetFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:file 
        {name : Name of the file}
	{--ip= : Alternative Ip address}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets a file with sftp';

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
        $name = $this->argument('name');
        $ip = $this->option('ip');
$file = Storage::disk('dbsftp')->get("dr/{$name}");
Storage::disk('local')->put("dr/{$name}", $file);
$this->info("File copied.");
      	/*
            system(
                'sshpass -p \''.env('SSH_PASS').'\' sftp '.env('SSH_USER').'@'.env('SSH_IP').'<< EOF 
            get /var/www/html/sirge3/storage/uploads/prestaciones/'.$name
            );
        */
    }
}
