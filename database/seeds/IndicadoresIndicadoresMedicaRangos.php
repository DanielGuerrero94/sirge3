<?php

use Illuminate\Database\Seeder;

class IndicadoresIndicadoresMedicaRangos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.indicadores_medica_rangos(id_provincia,periodo,codigo_indicador,max_rojo,max_verde,min_rojo,min_verde)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.37 user=postgres password=BernardoCafe008',
		    'SELECT id_provincia,periodo,codigo_indicador,max_rojo,max_verde,min_rojo,min_verde
			FROM
				indicadores.indicadores_medica_rangos;')
		    AS migracion(id_provincia char(2),
				periodo integer,
				codigo_indicador character varying(5),
				max_rojo integer,
				max_verde integer,
				min_rojo integer,
				min_verde integer
				)
	); ");
    }
}
