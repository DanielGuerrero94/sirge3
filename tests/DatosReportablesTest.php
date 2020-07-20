<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatosReportablesTest extends TestCase
{

    private function sample()
    {
	$prestacion = \App\Models\Prestacion::whereNotNull('datos_reportables')->first();
	return $prestacion->datos_reportables;
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
	$json = $this->sample();
	$sample = json_decode($json, true);
	$this->assertNull($sample);
	\DB::statement("insert into prestaciones.prestaciones_datos_reportables ()")
    }
}
