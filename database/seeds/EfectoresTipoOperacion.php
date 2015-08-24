<?php

use Illuminate\Database\Seeder;

class EfectoresTipoOperacion extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.tipo_operacion(id_operacion,descripcion)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_operacion,descripcion
		    FROM efectores.tipo_operacion')
	    AS migracion(id_operacion integer,
  descripcion character varying(100))
);");
	}
}
