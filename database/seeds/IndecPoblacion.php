<?php

use Illuminate\Database\Seeder;

class IndecPoblacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indec.poblacion(id_provincia, habitantes)
	(
		SELECT *
		FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
		    'SELECT id_provincia, habitantes	
			FROM
				indec.poblacion;')
		    AS migracion(id_provincia char(2),
				habitantes integer
				)
	); " );
    }
}
