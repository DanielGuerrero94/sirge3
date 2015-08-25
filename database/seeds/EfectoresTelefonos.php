<?php

use Illuminate\Database\Seeder;

class EfectoresTelefonos extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO efectores.telefonos(id_telefono,id_efector,numero_telefono,id_tipo_telefono,observaciones)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_telefono,id_efector,numero_telefono,id_tipo_telefono,observaciones
		    FROM efectores.telefonos')
	    AS migracion(id_telefono integer,
  id_efector integer,
  numero_telefono character varying(200),
  id_tipo_telefono integer,
  observaciones character varying(100))
);");
	}
}
