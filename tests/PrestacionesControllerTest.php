<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrestacionesControllerTest extends TestCase
{
    public function testAbrirArchivo()
    {
	$fh = app("App\Http\Controllers\PrestacionesController")->abrirArchivo(21279);
	$metadata = stream_get_meta_data($fh);
        $this->assertEquals($metadata['uri'], "/var/www/html/sirge3/storage/uploads/prestaciones/5dee910527366.txt");
    }

    public function testAbrirArchivoFalla()
    {
	$fh = app("App\Http\Controllers\PrestacionesController")->abrirArchivo(20627);
        $this->assertNotNull($fh['mensaje']);
    }

    /* Genera un ErrorSubida */
    public function testProcesarArchivoFalla()
    {
	//Borrar ErrorSubida
    	\App\Models\ErrorSubida::where('id_subida', 20627)->delete();
	$response = app("App\Http\Controllers\PrestacionesController")->procesarArchivo(20627);
	$success = json_decode($response->content())->success;

    	$count = \App\Models\ErrorSubida::where('id_subida', 20627)->count();
	$this->assertEquals($success, 'false');
	$this->assertEquals($count, 1);
	$this->assertNotNull($response);
    }

    /* procesa el archivo */
    public function testProcesarArchivo()
    {
	//$response = app("App\Http\Controllers\PrestacionesController")->procesarArchivo(21279);
	//dump($response);

	//$this->assertNull($response);
    }
    
}
