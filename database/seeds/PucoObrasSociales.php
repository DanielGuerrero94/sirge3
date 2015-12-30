<?php

use Illuminate\Database\Seeder;

class PucoObrasSociales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO puco.obras_sociales(id_osp,codigo_osp,sigla,nombre)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_osp, codigo_osp, sigla, nombre_os
			    FROM puco.obras_sociales order by id_osp desc')
		    AS migracion( id_osp integer,
				  codigo_osp integer,
				  sigla character varying(20),
				  nombre text )			
	); ");
    }
}
