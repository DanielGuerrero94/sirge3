<?php

use Illuminate\Database\Seeder;

class SistemaLotes extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

		\DB::statement(" INSERT INTO sistema.lotes(lote,id_subida,id_usuario,id_provincia,id_estado,registros_in,registros_out,inicio,fin)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT lote,(select id_carga from sistema.cargas_archivos c where c.lote = l.lote),id_usuario_proceso,case id_provincia when ''25'' then ''01'' else id_provincia end as id_provincia,coalesce(id_estado,2),registros_insertados,registros_rechazados,coalesce(inicio,now()),fin
			    FROM sistema.lotes l')
		    AS migracion( lote integer,
	  id_subida integer,
	  id_usuario integer,
	  id_provincia character(2),
	  id_estado integer,
	  registros_in integer,
	  registros_out integer,
	  inicio timestamp without time zone,
	  fin timestamp without time zone)
	);");
	}
}
