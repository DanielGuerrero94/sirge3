<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Efectores\Datos;

class DatosEfectorTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateDatosEfector()
    {
	//Posibles II; IIIA; IIIB
	$data = [
	    //'id_efector' => '8579',
	    'cuie' => 'B90838', 
	    'categoria_maternidad' => 'II',
	    'cumple_cone' => 'S',
	    'categoria_neonatologia' => 'IIIA',
	    'opera_malformaciones' => 'N',
	    'categoria_cc' => 'IIIB',
	    'categoria_iam' => 'IIA',
	    'red_flap' => 'S'
	];

	$datos = new Datos($data);
	$this->assertTrue($datos->save());

        $this->assertEquals(Datos::count(), 1);
	$datos->delete();
	$this->assertEquals(Datos::count(), 0);
    }
}
