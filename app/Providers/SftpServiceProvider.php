<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Storage;
use League\Flysystem\Sftp\SftpAdapter;
use League\Flysystem\Filesystem;

class SftpServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
	Storage::extend('sftp', function($app, $config) {
            $client = [
    'host' => '192.6.0.66',
    'username' => env('SSH_USER'),
    'password' => env('SSH_PASS'),
	'root' => '/tmp'
];

            return new Filesystem(new SftpAdapter($client));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
