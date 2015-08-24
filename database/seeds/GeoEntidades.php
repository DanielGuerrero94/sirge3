<?php

use Illuminate\Database\Seeder;

class GeoEntidades extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO geo.entidades(id_provincia,id_departamento,id_localidad,id_entidad,nombre_entidad)
 (
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
	    'SELECT id_provincia,id_departamento,id_localidad,id_entidad,nombre_entidad
		    FROM efectores.entidades')
	    AS sirge_entidades(id_provincia character(2),
			  id_departamento character(3),
			  id_localidad character(3),
			  id_entidad character(2),
			  nombre_entidad character varying(200)
			  )
 );"
		);
	}
}
