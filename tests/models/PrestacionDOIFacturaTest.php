<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\PrestacionDOIFacturada;
use Faker\Factory as Faker;

class PrestacionDOIFacturadaTest extends TestCase
{
    public function fakePrestacion()
    {
	$data = factory(App\Models\PrestacionDOIFacturada::class)->create();

	return $data;
    }

    public function testCreaFacturada()
    {
	$model = $this->fakePrestacion();
	$this->assertNotNull($model);
        $this->assertEquals(PrestacionDOIFacturada::count(), 1);
        $model->delete();
        $this->assertEquals(PrestacionDOIFacturada::count(), 0);
    }
}
