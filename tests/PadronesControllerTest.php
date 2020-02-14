<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PadronesControllerTest extends TestCase
{
    public function testGetName()
    {
	$name = app("App\Http\Controllers\PadronesController")->getName(10);
	$this->assertEquals($name, 'Prestaciones Doi3 Facturadas');
    }

    public function testGetNameWithRoute()
    {
	$name = app("App\Http\Controllers\PadronesController")->getName(10, true);
	$this->assertEquals($name, '../storage/uploads/prestaciones doi3 facturadas');
    }

    public function testGetMainViewData()
    {
	//$mock_request = request();
	//$mock_request->lote = 98816;
	    $some_user = \App\Models\Usuario::first();
	    $this->be($some_user);
	    $user = Auth::user();
	    $this->assertNotNull($user);
	$data = app("App\Http\Controllers\PadronesController")->getMainViewData(10);
        $this->assertNull($data);
    }

}
