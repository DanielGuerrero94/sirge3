<?php

use Illuminate\Database\Seeder;

class SistemaComentarios extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO sistema.comentarios(id_comentario,id_usuario,comentario,fecha_comentario)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_comentario,id_usuario,comentario,fecha
		    FROM sistema.comentarios')
	    AS migracion(id_comentario integer,
  id_usuario integer,
  comentario text,
  fecha_comentario timestamp(0) without time zone)
);");
	}
}
