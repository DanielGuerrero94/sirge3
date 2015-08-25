<?php

use Illuminate\Database\Seeder;

class SistemaParametros extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.parametros(id_parametro,descripcion,valor,created_at,updated_at)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id,descripcion,valor,now() as created_at,now() as updated_at
		    FROM sistema.parametros')
	    AS migracion(id_parametro integer,
  descripcion character varying(100),
  valor character varying(100),
  created_at timestamp(0) without time zone,
  updated_at timestamp(0) without time zone)
);");
	}
}
