<?php

use Illuminate\Database\Seeder;

class GeoGepDepartamentos extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO geo.gep_departamentos(id_punto,id_provincia,id_departamento,latitud,longitud)
(
	SELECT *
	FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
	    'SELECT id_punto,id_provincia,id_departamento,latitud,longitud
		    FROM geo.gep_departamentos')
	    AS migracion(  id_punto integer,
  id_provincia character(2),
  id_departamento character(3),
  latitud numeric,
  longitud numeric)
);");
	}
}
