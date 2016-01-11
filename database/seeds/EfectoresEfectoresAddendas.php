<?php

use Illuminate\Database\Seeder;

class EfectoresEfectoresAddendas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO efectores.efectores_addendas(id,id_efector,id_addenda,fecha_addenda,created_at,updated_at)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id,id_efector,id_addenda,fecha_addenda,created_at,updated_at
		    FROM efectores.efectores_addendas')
	    AS migracion(id integer,
					  id_efector integer,
					  id_addenda integer,
					  fecha_addenda date,
					  created_at timestamp without time zone,
					  updated_at timestamp without time zone)
);");
    }
}
