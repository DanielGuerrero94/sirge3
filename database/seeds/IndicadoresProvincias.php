<?php

use Illuminate\Database\Seeder;

class IndicadoresProvincias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.provincias(id_provincia,provincia)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_provincia,provincia
			FROM
				indicadores.provincias;')
		    AS migracion(id_provincia char(2),
				provincia character varying(40)				
				)
	); ");
    }
}
