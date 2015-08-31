<?php

use Illuminate\Database\Seeder;

class PssCodigosOdp extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.codigos_odp(codigo_prestacion,id_linea_cuidado,id_grupo_etario,id_odp)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT codigo_prestacion,id_linea_cuidado,id_grupo_etario,id_odp
			    FROM pss.codigos_odp')
		    AS migracion(codigo_prestacion character varying(11),
				  id_linea_cuidado smallint,
				  id_grupo_etario smallint,
				  id_odp smallint)
	);");
	}
}
