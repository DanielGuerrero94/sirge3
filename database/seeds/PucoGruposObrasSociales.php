<?php

use Illuminate\Database\Seeder;

class PucoGruposObrasSociales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO puco.grupos_obras_sociales(grupo_os,nombre_grupo,id_provincia)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT grupo_os,nombre_grupo,id_entidad
			    FROM puco.grupos_obras_sociales')
		    AS migracion(grupo_os integer,
				  nombre_grupo character varying(200),
				  id_provincia character(2))			
	); ");
    }
}
