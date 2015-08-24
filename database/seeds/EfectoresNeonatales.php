<?php

use Illuminate\Database\Seeder;

class EfectoresNeonatales extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.efectores_neonatales(siisa,id_categoria)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT siisa,id_categoria
		    FROM efectores.efectores_neonatales')
	    AS migracion(siisa character varying(14),id_categoria integer)
);");
	}
}
