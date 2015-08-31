<?php

use Illuminate\Database\Seeder;

class PssLineasCuidado extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.lineas_cuidado(id_linea_cuidado,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_linea_cuidado,descripcion
			    FROM pss.lineas_cuidado')
		    AS migracion(id_linea_cuidado smallint,descripcion text)
	);");
	}
}
