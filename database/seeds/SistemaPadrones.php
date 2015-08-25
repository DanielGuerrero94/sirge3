<?php

use Illuminate\Database\Seeder;

class SistemaPadrones extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.padrones(id_padron,descripcion,created_at,updated_at)
(
	SELECT *
	FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
	    'SELECT id_padron,nombre,now() as created_at,now() as updated_at
		    FROM sistema.padrones')
	    AS migracion(id_padron integer,
  descripcion character varying(100),
  created_at timestamp(0) without time zone,
  updated_at timestamp(0) without time zone)
);");
	}
}
