<?php

use Illuminate\Database\Seeder;

class PucoResumenPuco extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO puco.resumen_puco(id_puco,periodo,clave,registros)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_puco,periodo,clave,registros
			    FROM puco.resumen_puco')
		    AS migracion(id_puco integer,
				  periodo integer,
				  clave character varying(8),
				  registros bigint)
	);	");
    }
}
