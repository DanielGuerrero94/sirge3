<?php

use Illuminate\Database\Seeder;

class PssCodigosSumarNacer extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.codigos_sumar_nacer(codigo_prestacion,id_grupo_etario,codigo_prestacion_nacer,codigo_prestacion_rural)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT codigo_prestacion,id_grupo_etario,codigo_prestacion_nacer,codigo_prestacion_rural
			    FROM pss.codigos_sumar_nacer')
		    AS migracion(codigo_prestacion character varying(11),
				  id_grupo_etario smallint,
				  codigo_prestacion_nacer character varying(6),
				  codigo_prestacion_rural character varying(11))
	);");
	}
}
