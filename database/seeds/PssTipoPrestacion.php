<?php

use Illuminate\Database\Seeder;

class PssTipoPrestacion extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.tipo_prestacion(tipo_prestacion,descripcion,icono)
	(
		SELECT *
		FROM dblink('dbname=sirge2 host=192.6.0.36 user=postgres password=BernardoCafe008',
		    'SELECT tipo_prestacion, descripcion, icono
			    FROM pss.tipo_prestacion')
		    AS migracion( tipo_prestacion character varying(2),
				 descripcion character varying(50),
				 icono character varying(40))
	);");
		
	}
}
