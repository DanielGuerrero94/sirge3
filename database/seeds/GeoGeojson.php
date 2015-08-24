<?php

use Illuminate\Database\Seeder;

class GeoGeojson extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO geo.geojson(id_provincia,geojson_provincia)
(
	SELECT *
	FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
	    'SELECT id_provincia,geojson_provincia
		    FROM geo.geojson')
	    AS migracion(id_provincia character(2),geojson_provincia character varying(5))
);");
	}
}
