<?php

use Illuminate\Database\Seeder;

class PssCodigosSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\DB::statement(" INSERT INTO pss.codigos(codigo_prestacion, tipo, objeto, diagnostico, codigo_logico, descripcion_grupal ,created_at, updated_at)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT codigo_prestacion, tipo, objeto, diagnostico, codigo_logico, descripcion_grupal, inserted_at, updated_at
			    FROM pss.codigos')
		    AS sirge_codigos( codigo_prestacion character varying(11),
							  tipo character(2),
							  objeto character(4),
							  diagnostico character(5),
							  codigo_logico character(1),
							  descripcion_grupal text,
							  inserted_at date,
							  updated_at date)
							)
        	");

	}
}
