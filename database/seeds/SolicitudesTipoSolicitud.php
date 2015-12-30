<?php

use Illuminate\Database\Seeder;

class SolicitudesTipoSolicitud extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO solicitudes.tipo_solicitud(id, grupo, descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
		    'SELECT id, grupo, descripcion
			    FROM solicitudes.tipo_solicitud')
		    AS migracion( id integer,
						  grupo integer,
						  descripcion character varying(100)
						)			
	); ");
    }
}
