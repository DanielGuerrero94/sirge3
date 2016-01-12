<?php

use Illuminate\Database\Seeder;

class EfectoresTipoEstado extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.tipo_estado(id_estado,descripcion,css)
(
	SELECT *
	FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
	    'SELECT id_estado,descripcion,css
		    FROM efectores.tipo_estado')
	    AS migracion(id_estado integer,
  descripcion character varying(100),
  css character varying(10))
);");
	}
}
