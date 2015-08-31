<?php

use Illuminate\Database\Seeder;

class PssModulosCCC extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.modulos_ccc(id_modulo,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_modulo,descripcion
			    FROM pss.modulos_ccc')
		    AS migracion(id_modulo smallint,descripcion text)
	);");
	}
}
