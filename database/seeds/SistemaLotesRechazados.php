<?php

use Illuminate\Database\Seeder;

class SistemaLotesRechazados extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.lotes_rechazados(lote,id_usuario,fecha_rechazado)
	(
		SELECT lote_posta,id_usuario_posta,fecha_rechazado_posta
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT l1.lote,l1.id_usuario_baja_lote,l1.fecha_baja_lote
			    FROM sistema.lotes l1')
		    AS migracion(lote_posta integer,
				  id_usuario_posta integer,
				  fecha_rechazado_posta timestamp(0) without time zone)

		INNER JOIN sistema.lotes l ON l.lote = lote_posta
		AND id_estado = 3
	);");
		
		\DB::statement(" INSERT INTO sistema.lotes_rechazados(id_usuario,fecha_rechazado) VALUES (191,now());")

");
	}
}
