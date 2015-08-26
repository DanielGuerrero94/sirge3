<?php

use Illuminate\Database\Seeder;

class EfectoresReferentes extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO efectores.referentes(id_referente,id_efector,nombre)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_referente,id_efector,nombre
		    FROM efectores.referentes')
	    AS migracion(id_referente integer,
  id_efector integer,
  nombre character varying(200))
);");
	}
}
