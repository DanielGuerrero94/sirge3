<?php

use Illuminate\Database\Seeder;

class GeoUbicacionProvincias extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO geo.ubicacion_provincias(id_provincia,latitud,longitud)
(
	SELECT *
	FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
	    'SELECT id_provincia,split_part(ll, '','', 1):: double precision as latitud,split_part(ll,'','', 2):: double precision as longitud
		    FROM geo.provincias')
	    AS migracion(id_provincia character(2),
  latitud  double precision,
  longitud  double precision)
);");
	}
}
