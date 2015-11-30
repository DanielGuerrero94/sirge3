<?php

use Illuminate\Database\Seeder;

class IndicadoresIndicadoresMedica extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.indicadores_medica(id_provincia,periodo,codigo_indicador,resultado)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_provincia,periodo,codigo_indicador,coalesce(resultado,0)
			FROM
				indicadores.indicadores_medica;')
		    AS migracion(id_provincia char(2),
				periodo integer,
				codigo_indicador character varying(6),
				resultado integer
				)
	); ");
    }
}
