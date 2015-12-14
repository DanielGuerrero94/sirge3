<?php

use Illuminate\Database\Seeder;

class EfectoresAddendas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO efectores.addendas(id,nombre)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id,nombre
		    FROM efectores.addendas')
	    AS migracion(id integer,
  					 nombre character varying(50))
);");
    }
}
