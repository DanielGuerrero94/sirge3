<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\PrestacionDOIFacturada;
use Faker\Factory as Faker;

class EfectorTest extends TestCase
{
    public function fakeEfector()
    {
	$data = factory(App\Models\Efector::class)->create();

	return $data;
    }

    public function testCreaEfector()
    {
	$data = $this->fakeEfector();
	$model = new Efector($data->toArray());
	$this->assertNotNull($model);
	$model->save();
        $this->assertEquals(Efector::count(), 1);
        $model->delete();
        $this->assertEquals(Efector::count(), 0);
    }
}
