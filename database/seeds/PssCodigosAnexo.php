<?php

use Illuminate\Database\Seeder;

class PssCodigosAnexo extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.codigos_anexo(codigo_prestacion,id_grupo_etario)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT codigo_prestacion,id_grupo_etario
			    FROM pss.codigos_anexo')
		    AS migracion(codigo_prestacion character varying(11),
				 id_grupo_etario smallint)
	);");
	}
}
