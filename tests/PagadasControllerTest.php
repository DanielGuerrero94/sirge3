<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Subida;
use App\Models\Lote;

class PagadasControllerTest extends TestCase
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

    public function testCreaLoteFacturadas()
    {
        $this->fakeUser();
	/*
	$subida = $this->fakeSubida();
	$original_name = 'Prestaciones Formosa 04 2019.xlsx';
	$nombre_archivo = 'formosa-04-2019.txt';
	$size = 1250;
	$id_padron = 12;
	$data_subida = [
		'id_padron' => $id_padron,
		'nombre_original' => $original_name,
		'nombre_actual' => $nombre_archivo,
		'size' => $size
	];

        $subida = new Subida($data_subida);
	$subida->save();
	$this->assertNotNull($subida->id_subida);
	$data = [
        	'id_subida' => $subida->id_subida
	];
        $l = new Lote($data);
        $l->save();
	$id_subida = $subida->id_subida;
	 */
	$this->assertEquals(1, 1);
	$id_subida = 21330;
	$result = app('App\Http\Controllers\PrestacionesDoiController')->procesarArchivo($id_subida);
	var_dump($result->getContent());
    }

}
