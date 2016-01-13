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
		FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
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
