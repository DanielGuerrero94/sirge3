<?php

use Illuminate\Database\Seeder;

class SistemaTipoEntidad extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.tipo_entidad(id_tipo_entidad,descripcion)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
	    'SELECT id_tipo_identidad,descripcion
		    FROM sistema.tipo_entidad')
	    AS migracion(id_tipo_entidad integer,descripcion character varying(100))
);
		");
	}
}
