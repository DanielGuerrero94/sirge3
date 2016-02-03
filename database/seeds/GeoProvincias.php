<?php

use Illuminate\Database\Seeder;

class GeoProvincias extends Seeder {
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
							FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008',
							    'SELECT id_provincia, descripcion, id_region, latlong
								    FROM geo.provincias')
							    AS sirge_provincias(id_provincia character(2), descripcion character varying(100), id_region integer, ll character varying(100))
						 )
        			   	");


	}
}
