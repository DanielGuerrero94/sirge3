<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RequiereDRTest extends TestCase
{
    public function lotesProvider()
    {
        return [
            ['12277'],
        ];
    }

    /**
     * Busca todas las prestaciones del lote que necesitan dato reportable segun su codigo de prestacion
     *
     * @test
     * @dataProvider lotesProvider
     */
    public function datosReportablesLotes($lote)
    {
	$count = DB::select("select count(*) from prestaciones.prestaciones p join prestaciones.requiere_datos_reportables r on r.codigo_prestacion = p.codigo_prestacion and p.fecha_prestacion between r.vigencia_desde and r.vigencia_hasta where lote = {$lote}")[0]->count;
        $this->assertEquals(7673, $count);
    }

}

