<?php

use Illuminate\Database\Seeder;

class PssCodigosPpac extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO pss.codigos_ppac(codigo_prestacion,id_linea_cuidado,id_grupo_etario,modulo,sara,ambulatorio,internacion,hospital_dia,traslado,patologia_quirurgica,patologia_prematurez,ii,iiia,iiib)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT codigo_prestacion,id_linea_cuidado,id_grupo_etario,modulo,sara,ambulatorio,internacion,hospital_dia,traslado,patologia_quirurgica,patologia_prematurez,ii,iiia,iiib
			    FROM pss.codigos_ppac')
		    AS migracion(codigo_prestacion character varying(11),
				  id_linea_cuidado smallint,
				  id_grupo_etario smallint,
				  modulo character varying(1),
				  sara character varying(1),
				  ambulatorio character varying(1),
				  internacion character varying(1),
				  hospital_dia character varying(1),
				  traslado character varying(1),
				  patologia_quirurgica character varying(1),
				  patologia_prematurez character varying(1),
				  ii character varying(1),
				  iiia character varying(1),
				  iiib character varying(1))
	);");
	}
}
