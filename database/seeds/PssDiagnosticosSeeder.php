<?php

use Illuminate\Database\Seeder;

class PssDiagnosticosSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\DB::statement(" INSERT INTO pss.diagnosticos(id_grupo_diagnostico, diagnostico, matriz_extendida, descripcion)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT id_grupo_diagnostico, diagnostico, matriz_extendida, descripcion
			    FROM pss.diagnosticos')
		    AS sirge_diagnosticos(id_grupo_diagnostico smallint, diagnostico character varying(5), matriz_extendida character varying(1), descripcion text)
	 )
	");

	}
}
