<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Subida;
use App\Models\Lote;

class PadronesControllerTest extends TestCase
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
	//$subida = $this->fakeSubida();
	$original_name = 'Prestaciones tucuman 03 2019.xlsx';
	$nombre_archivo = 'tucu-03-2019.txt';
	$size = 58690683;
	$id_padron = 10;
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
	$result = app('App\Http\Controllers\PrestacionesDoiFacturadasController')->procesarArchivo($subida->id_subida);
	var_dump($result->getContent());
    }

}
