<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Models\Efectores\Recupero;

class RecuperoCostosTest extends TestCase
{

    public function testCreateModel()
    {
    }
        
    public function testAddToEfector()
    {
        $data = [
        'OSP' => 'N',
        'PAMI' => 'S',
        'DIRECTO' => 'N'
        ];

        $datos = new Recupero($data);
        $this->assertTrue($datos->save());

        $this->assertEquals(Recupero::count(), 1);
        $datos->delete();
        $this->assertEquals(Datos::count(), 0);
    }
}
