<?php

use Illuminate\Database\Seeder;

class GeoLocalidades extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO geo.localidades(id_provincia,id_departamento,id_localidad,nombre_localidad)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_provincia,id_departamento,id_localidad,nombre_localidad
		    FROM efectores.localidades')
	    AS migracion(  id_provincia character(2),
  id_departamento character(3),
  id_localidad character(3),
  nombre_localidad character varying(200))
);");
	}
}
