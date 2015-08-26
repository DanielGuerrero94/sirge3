<?php

use Illuminate\Database\Seeder;

class SistemaModulos extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.modulos(id_modulo,nivel_1,nivel_2,descripcion,modulo,icono)
(
	SELECT *
	FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
	    'SELECT id_modulo,nivel_1,nivel_2,nombre,modulo,icono_metronic
		    FROM sistema.modulos')
	    AS migracion(id_modulo integer,
  nivel_1 integer,
  nivel_2 integer,
  descripcion character varying(100),
  modulo character varying(100),
  icono character varying(255))
);");
	}
}
