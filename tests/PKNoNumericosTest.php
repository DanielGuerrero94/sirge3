<?php

use App\Models\Indicadores\Descripcion;
use App\Models\ClaseDocumento;
use App\Models\TipoPrestacion;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PKNoNumericosTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Tiene que fallar al crear porque la primary es incremental cuando no deberia.
     * Y si no se le pasa su primary key no tiene forma de guardar el modelo.
     *
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function descripcion()
    {
        $descripcion = new Descripcion();
        $descripcion->descripcion = 'test';
        $descripcion->save();
    }

    /** @test */
    public function descripcion_puede_crearse()
    {
        $descripcion = new Descripcion();
        $descripcion->indicador = 9.9;
        $descripcion->descripcion = 'test';
        $descripcion->save();
        $this->assertEquals(9.9, $descripcion->indicador);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function claseDocumento()
    {
        $claseDocumento = new ClaseDocumento();
        $claseDocumento->descripcion = 'test';
        $claseDocumento->save();
    }

    /** @test */
    public function clase_documento_puede_crearse()
    {
        $claseDocumento = new ClaseDocumento();
        $claseDocumento->descripcion = 'test';
        $claseDocumento->clase_documento = 'R';
        $claseDocumento->save();
        $this->assertEquals('R', $claseDocumento->clase_documento);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function tipoPrestacion()
    {
        $tipoPrestacion = new TipoPrestacion();
        $tipoPrestacion->descripcion = 'test';
        $tipoPrestacion->save();
    }

    /** @test */
    public function tipo_prestacion_puede_crearse()
    {
        $tipoPrestacion = new TipoPrestacion();
        $tipoPrestacion->descripcion = 'test';
        $tipoPrestacion->tipo_prestacion = 'ZZ';
        $tipoPrestacion->save();
        $this->assertEquals('ZZ', $tipoPrestacion->tipo_prestacion);
    }
}
