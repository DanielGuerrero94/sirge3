<?php

use Illuminate\Database\Seeder;

class EfectoresOperaciones extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.operaciones(id_efector,id_usuario,fecha,observaciones)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_efector,id_usuario_operacion,fecha_operacion,observaciones
		    FROM efectores.operaciones')
	    AS migracion(id_efector integer,
	    id_usuario_operacion integer,
  fecha_operacion date,
  observaciones text)
);");
	}
}
