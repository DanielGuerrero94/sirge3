<?php

use Illuminate\Database\Seeder;

class EfectoresTipoTelefono extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.tipo_telefono(id_tipo_telefono,descripcion)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_tipo_telefono,descripcion
		    FROM efectores.tipo_telefono')
	    AS migracion(id_tipo_telefono integer,
  descripcion character varying(100))
);");
	}
}
