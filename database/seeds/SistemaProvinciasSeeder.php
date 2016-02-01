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
		\DB::statement(" CREATE EXTENSION dblink; ");

		\DB::statement(" INSERT INTO geo.provincias(id_provincia,descripcion,id_region,latlong)
						 (
							SELECT *
							FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
							    'SELECT id_entidad, descripcion, id_region, (SELECT ll FROM geo.provincias gp WHERE p.id_entidad = gp.id_provincia) as ll
								    FROM sistema.entidades p where id_entidad::integer < 25')
							    AS sirge_provincias(id_provincia character varying(2), descripcion character varying(100), id_region integer, ll character varying(100))
						 )
        			   	");


	}
}
