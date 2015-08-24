<?php

use Illuminate\Database\Seeder;

class PssGruposEtarios extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO pss.grupos_etarios(id_grupo_etario,sigla,edad_min,edad_max,descripcion)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT id_grupo_etario,sigla,edad_min,edad_max,descripcion
			    FROM pss.grupos_etarios')
		    AS sirge_grupos_etarios(id_grupo_etario smallint,sigla char(3),edad_min text,edad_max text,descripcion text)
	 )
        			   	");
	}
}
