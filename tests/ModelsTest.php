<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\Codigo;
use App\Models\CEI\Grupo;

class ModelsTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * Tiene que fallar al crear porque la primary es incremental cuando no deberia.     
     *
     * @expectedException Illuminate\Database\QueryException
     * @return void
     */
    public function testCodigo()
    {
	$codigo = new Codigo();
	$codigo->tipo = 'ZZ';
	$codigo->save();
    }

    public function testComentario() 
    {
	$grupo = new Grupo();
	$grupo->nombre = 'test';
	$grupo->save();
	$this->assertTrue(is_numeric($grupo->id));
    }
}
