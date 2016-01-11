<?php

use Illuminate\Database\Seeder;

class IndicadoresMetasEfectoresPriorizados extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indicadores.metas_efectores_priorizados(efector,base,c1,c2,c3,indicador)
	(
		SELECT *
		FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
		    'SELECT efector,base,c1,c2,c3,indicador
			FROM
				indicadores.metas_efectores_priorizados;')
		    AS migracion(efector character varying (14),
				base double precision,
				c1 double precision,
				c2 double precision,
				c3 double precision,
				indicador character varying(5)				
				)
	); ");
    }
}
