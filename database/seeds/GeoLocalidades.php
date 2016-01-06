<?php

use Illuminate\Database\Seeder;

class GeoLocalidades extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO geo.localidades(id,id_provincia,id_departamento,id_localidad,nombre_localidad)
(
	SELECT *
	FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
	    'SELECT id,id_provincia,id_departamento,id_localidad,nombre_localidad
		    FROM geo.localidades')
	    AS migracion( id integer,id_provincia character(2),
  id_departamento character(3),
  id_localidad character(3),
  nombre_localidad character varying(200))
);");
	}
}
