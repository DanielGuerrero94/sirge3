<?php

use Illuminate\Database\Seeder;

class PssCodigosSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\DB::statement(" INSERT INTO pss.codigos(codigo_prestacion, tipo, objeto, diagnostico, codigo_logico)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT codigo_prestacion, tipo, objeto, diagnostico, codigo_logico
			    FROM pss.codigos')
		    AS sirge_codigos(codigo_prestacion character varying (11), tipo character varying(2), objeto character varying(4), diagnostico character varying(5), codigo_logico character varying(1))
	 )
        	");

	}
}
