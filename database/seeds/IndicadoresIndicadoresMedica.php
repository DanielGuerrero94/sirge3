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
        \DB::statement(" INSERT INTO indicadores.indicadores_medica(id_provincia,periodo,codigo_indicador,resultado,id_rango_indicador)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_provincia,periodo,codigo_indicador,coalesce(resultado,0),id_rango_indicador
		    (SELECT r.id_rango_indicador FROM indicadores.indicadores_medica_rangos r WHERE i.id_provincia = r.id_provincia AND substring(r.periodo,1,4) = substring(i.periodo,1,4) AND left(i.codigo_indicador,-2) =  r.codigo_indicador) as id_rango_indicador
			FROM
				indicadores.indicadores_medica i;')
		    AS migracion(id_provincia char(2),
				periodo integer,
				codigo_indicador character varying(6),
				resultado integer,
				id_rango_indicador integer
				)
	); ");
    }
}
