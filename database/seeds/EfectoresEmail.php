<?php

use Illuminate\Database\Seeder;

class EfectoresEmail extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO efectores.email(id_email,id_efector,email,observaciones)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_email,id_efector,email,observaciones
		    FROM efectores.email')
	    AS migracion(id_email integer,
  id_efector integer,
  email character varying(200),
  observaciones character varying(100))
);");
	}
}
