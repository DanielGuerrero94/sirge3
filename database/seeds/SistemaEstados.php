<?php

use Illuminate\Database\Seeder;

class SistemaEstados extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.estados(id_estado,descripcion,created_at,updated_at)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_estado,descripcion,now() as created_at,now() as updated_at
		    FROM sistema.tipo_estado')
	    AS migracion(id_estado integer,
  descripcion character varying(100),
  created_at timestamp(0) without time zone,
  updated_at timestamp(0) without time zone)
);");
	}
}
