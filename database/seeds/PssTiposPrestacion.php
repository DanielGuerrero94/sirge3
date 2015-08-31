<?php

use Illuminate\Database\Seeder;

class PssTiposPrestacion extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.tipos_prestacion(tipo_prestacion,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
		    'SELECT tipo_prestacion,descripcion
			    FROM pss.tipos_prestacion')
		    AS migracion(tipo_prestacion character varying(2),
				 descripcion text)
	);");
	}
}
