<?php

use Illuminate\Database\Seeder;

class PssGruposDiagnosticos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO pss.grupos_diagnosticos(id_grupo_diagnostico,sigla,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_grupo_diagnostico,sigla,descripcion
			    FROM pss.grupos_diagnosticos')
		    AS migracion( id_grupo_diagnostico smallint,
				sigla character varying(4),
				descripcion text)
	);");
    }
}
