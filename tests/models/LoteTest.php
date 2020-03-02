<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Lote;
use Faker\Factory as Faker;

class LoteTest extends TestCase
{
    public function fakeLote()
    {
	return factory(App\Models\Lote::class)->make();
    }

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

    public function testCreaLote()
    {
	$this->fakeUser();
	$subida = $this->fakeSubida();
	$data = [
        	'id_subida' => $subida->id_subida
	];
        $l = new Lote($data);
        $l->save();
        $this->assertEquals(Lote::pendientes()->count(), 1);
        $l->delete();
        $this->assertEquals(Lote::pendientes()->count(), 0);
    }

    public function testDevuelvePendientes()
    {
        $this->assertEquals(Lote::pendientes()->count(), 0);
    }

}
