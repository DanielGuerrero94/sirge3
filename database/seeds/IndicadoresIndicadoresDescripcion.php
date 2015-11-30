<?php

use Illuminate\Database\Seeder;

class IndicadoresIndicadoresDescripcion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.indicadores_descripcion(indicador,descripcion,numerador,denominador)
	(
		SELECT *
		FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
		    'SELECT indicador,descripcion,numerador,denominador
			FROM
				indicadores.indicadores_descripcion;')
		    AS migracion(indicador character varying(8),
				descripcion text,
				numerador text,
				denominador text
				)
	);  ");
    }
}
