<?php

use Illuminate\Database\Seeder;

class EstadisticasReportes extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO estadisticas.reportes(id,titulo,descripcion,form,css,tags)
(
	SELECT *
	FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008',
	    'SELECT id,titulo,descripcion,form,css,tags
		    FROM estadisticas.reportes')
	    AS migracion(  id integer,
					  titulo character varying(100),
					  descripcion text,
					  form character varying,
					  css character varying,
					  tags character varying[]
					  )
);");

    }
}
