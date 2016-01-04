<?php

use Illuminate\Database\Seeder;

class SolicitudesGrupos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO solicitudes.grupos(id, descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
		    'SELECT id, descripcion
			    FROM solicitudes.grupos')
		    AS migracion( id integer,
						  descripcion character varying(100)
						)			
	); ");
    }
}
