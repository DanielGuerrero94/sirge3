<?php

use Illuminate\Database\Seeder;

class GeoDepartamentos extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO geo.departamentos(id_provincia,id_departamento,nombre_departamento)
 (
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
	    'SELECT id_provincia,id_departamento,nombre_departamento
		    FROM efectores.departamentos')
	    AS sirge_departamentos(id_provincia character(2),
			  id_departamento character(3),
			  nombre_departamento character varying(200)
			  )
 ); ");
	}
}
