<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Subida;
use Faker\Factory as Faker;

class SubidaTest extends TestCase
{
    public function fakeSubida()
    {
	return factory(App\Models\Subida::class)->make();
    }

    public function fakeUser()
    {
	$admin = \App\Models\Usuario::where('id_usuario', '276')->first();
	$this->be($admin);
	return Auth::user();
    }

    public function testCreaSubida()
    {
	$user = $this->fakeUser();
	$data = $this->fakeSubida();
        $s       = new Subida($data->toArray());
        $s->save();
        $this->assertEquals(Subida::pendientes()->count(), 1);
        $s->delete();
        $this->assertEquals(Subida::pendientes()->count(), 0);
    }

    public function testDevuelvePendientes()
    {
        $this->assertEquals(Subida::pendientes()->count(), 0);
    }

}
