<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\DdjjController;
use App\Models\Usuario;

class DataDDJJDRTest extends TestCase
{
    use DatabaseTransactions;
	
    public $user;
    public $ddjj;

    public function setUp() {
	parent::setUp();
	$this->user = new Usuario(['id_provincia' => '01']);
	$this->ddjj = new DdjjController();
	$this->be($this->user);
    }

    /**
     * Para el padron 1 el resumen tiene los ids de datos reportables.
     * @test
     */
    public function resumen_tiene_totales_dr()
    {
	$resumen_dr = $this->ddjj->getDataDDJJSirge(1,5024)['resumen'];
	$this->assertArrayHasKey('validos', $resumen_dr);
	$this->assertArrayHasKey('ausentes', $resumen_dr);
	$this->assertArrayHasKey('errores', $resumen_dr);
    }

    /**
     * Para el padron 1 el lote tiene sus counts de datos reportables.
     * @test
     */
    public function lote_tiene_counts_dr()
    {
	$lote = $this->ddjj->getDataDDJJSirge(1,5024)['lotes'][0];
	$this->assertEquals(115, $lote->validos);
	$this->assertEquals(0, $lote->ausentes);
	$this->assertEquals(108, $lote->errores);
    }


}
