<?php

use App\Models\Codigo;
use App\Models\Salud;
use App\Mocks\DatoReportableMock as DatoReportable;
use App\Models\PSS\Grupo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class PKCodigoPrestacionTest extends TestCase
{
  use DatabaseTransactions;

    /**
     * Tiene que fallar al crear porque la primary es incremental cuando no deberia.
     * Y si no se le pasa su primary key no tiene forma de guardar el modelo.
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

    /** @test */
    public function codigo_puede_crearse()
    {
      $codigo = new Codigo();
      $codigo->codigo_prestacion = 'AAAAAA';
      $codigo->save();
      $this->assertEquals('AAAAAA', $codigo->codigo_prestacion);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function salud()
    {
      $salud = new Salud();
      $salud->tipo = 'ZZ';
      $salud->save();
    }

    /** @test */
    public function salud_puede_crearse()
    {
      $salud = new Salud();
      $salud->codigo_prestacion = 'AAAAAA';
      $salud->save();
      $this->assertEquals('AAAAAA', $salud->codigo_prestacion);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function grupo()
    {
      $grupo = new Grupo();
      $grupo->id_linea_cuidado = 1;
      $grupo->id_grupo_etario = 1;
      $grupo->save();
    }

    /** @test */
    public function grupo_puede_crearse()
    {
      $codigo = new Codigo();
      $codigo->codigo_prestacion = 'AAAAAA';
      $codigo->save();
      $grupo = new Grupo();
      $grupo->codigo_prestacion = 'AAAAAA';
      $grupo->id_linea_cuidado = 1;
      $grupo->id_grupo_etario = 1;
      $grupo->save();
      $this->assertEquals('AAAAAA', $grupo->codigo_prestacion);
    }

    /**
     * @test
     * @expectedException Illuminate\Database\QueryException
     */
    public function DatoReportable()
    {
      $codigo = new Codigo();
      $codigo->codigo_prestacion = 'AAAAAA';
      $codigo->save();
      $DatoReportable = new DatoReportable();
      $DatoReportable->tipo = 'ZZ';
      $DatoReportable->save();
    }

    /** @test */
    public function dato_reportable_puede_crearse()
    {
      $codigo = new Codigo();
      $codigo->codigo_prestacion = 'AAAAAA';
      $codigo->save();
      $DatoReportable = new DatoReportable();
      $DatoReportable->codigo_prestacion = 'AAAAAA';
      $DatoReportable->save();
      $this->assertEquals('AAAAAA', $DatoReportable->codigo_prestacion);
    }
  }
