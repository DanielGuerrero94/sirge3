<?php

use Illuminate\Database\Seeder;

class PssCodigosDatosReportables extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO pss.codigos_datos_reportables(codigo_prestacion ,created_at, updated_at)
	 (
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008',
		    'SELECT codigo_prestacion, now(), now()
			    FROM pss.codigos_datos_reportables')
		    AS sirge_codigos( codigo_prestacion character varying(11),
							  created_at date,
							  updated_at date)
							)
        	");
    }
}
