<?php

use Illuminate\Database\Seeder;

class TrazadorasTrazadoras extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO trazadoras.trazadoras(id_trazadora,nombre)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.3.0.66 user=postgres password=BernardoCafe008',
		    'SELECT id_trazadora,nombre
			    FROM trazadoras.trazadoras')
		    AS migracion(id_trazadora smallint,
				  nombre character varying(200))
	);");
    }
}
