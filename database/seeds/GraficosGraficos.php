<?php

use Illuminate\Database\Seeder;

class GraficosGraficos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO graficos.graficos(id,titulo,descripcion,form,css,tags)
(
	SELECT *
	FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
	    'SELECT id,titulo,descripcion,form,css,tags
		    FROM graficos.graficos')
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
