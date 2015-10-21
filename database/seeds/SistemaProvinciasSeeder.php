<?php

use Illuminate\Database\Seeder;

class SistemaProvinciasSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::statement(" INSERT INTO geo.provincias(id_provincia,descripcion,id_region)
						 (
							SELECT *
							FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
							    'SELECT id_provincia, nombre, id_region
								    FROM sistema.provincias')
							    AS sirge_provincias(id_provincia character varying(2), descripcion character varying(100), id_region integer)
						 )
        			   	");
	}
}
