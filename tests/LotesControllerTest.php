<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LotesControllerTest extends TestCase
{
    public function testGetName()
    {
	$name = app("App\Http\Controllers\LotesController")->getName(1);
        $this->assertEquals($name, "prestaciones");
    }

    public function testGetNameWithoutErrors()
    {
	$name = app("App\Http\Controllers\LotesController")->getName(0);
        $this->assertEquals($name, "");
    }

    public function testGetNameCatchError()
    {
	$name = app("App\Http\Controllers\LotesController")->getName(10);
        $this->assertEquals($name, "");
    }


    public function testGetNameWithRoute()
    {
	$name = app("App\Http\Controllers\LotesController")->getName(1, true);
        $this->assertEquals($name, "../storage/uploads/" . "prestaciones");
    }

    public function testGetNombrePadron()
    {
	$name = app("App\Http\Controllers\LotesController")->getNombrePadron(6);
        $this->assertEquals($name, "SUPERINTENDENCIA DE SERVICIOS DE SALUD");
    }

    public function testGetNombrePadronCatchError()
    {
	$name = app("App\Http\Controllers\LotesController")->getNombrePadron(10);
        $this->assertEquals($name, "");
    }

    public function testEliminaLote()
    {
	$mock_request = request();
	$mock_request->lote = 18816;
	$respuesta = app("App\Http\Controllers\LotesController")->eliminarLote($mock_request);
        $this->assertEquals($respuesta, 'Se ha rechazado el lote.');
    }

    public function testEliminarLoteNoExiste()
    {
	$mock_request = request();
	$mock_request->lote = 98816;
	$respuesta = app("App\Http\Controllers\LotesController")->eliminarLote($mock_request);
        $this->assertEquals($respuesta->status(), 404);
    }






}
