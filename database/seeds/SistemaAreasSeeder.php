<?php

use Illuminate\Database\Seeder;

class SistemaAreasSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.areas(id_area,nombre)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT id_area, nombre
			    FROM sistema.areas')
		    AS sirge_areas(id_area integer, nombre character varying(100))
	 )
        			   	");
	}
}
