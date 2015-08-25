<?php

use Illuminate\Database\Seeder;

class SistemaModulosMenu extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.modulos_menu(id_menu,id_modulo,created_at,updated_at)
(
	SELECT *
	FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
	    'SELECT id_menu,id_modulo,now(),now()
		    FROM sistema.modulos_menu')
	    AS migracion(id_menu integer,
  id_modulo integer,
  created_at timestamp(0) without time zone,
  updated_at timestamp(0) without time zone)
);");
	}
}
