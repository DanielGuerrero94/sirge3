<?php

use Illuminate\Database\Seeder;

class SistemaSugerencias extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.sugerencias(id_sugerencia,id_usuario,sugerencia,fecha)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id,id_usuario,sugerencia,fecha
		    FROM sistema.sugerencias')
	    AS migracion(id_sugerencia integer,
  id_usuario integer,
  sugerencia text,
  fecha timestamp(0) without time zone)
);");
	}
}
