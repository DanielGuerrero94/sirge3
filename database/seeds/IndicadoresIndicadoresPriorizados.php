<?php

use Illuminate\Database\Seeder;

class IndicadoresIndicadoresPriorizados extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.indicadores_priorizados(efector,periodo,numerador,id_provincia,indicador,denominador,nombre)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT efector,periodo,numerador,id_provincia,indicador,denominador,nombre
			FROM
				indicadores.indicadores_priorizados;')
		    AS migracion(efector character varying (8),
				periodo integer,
				numerador integer,
				id_provincia char(2),
				indicador character varying(5),
				denominador integer,
				nombre character varying(200)
				)
	); ");
    }
}
