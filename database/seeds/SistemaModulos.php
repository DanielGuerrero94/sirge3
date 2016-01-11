<?php

use Illuminate\Database\Seeder;

class SistemaModulos extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.modulos(id_modulo,arbol,nivel_1,nivel_2,descripcion,modulo,icono,id_padre)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
		    'SELECT id_modulo,arbol,nivel_1,nivel_2,descripcion,modulo,icono,id_padre
			    FROM sistema.modulos')
		    AS migracion(id_modulo serial,
						  arbol character(1),
						  nivel_1 integer,
						  nivel_2 integer,
						  descripcion character varying(100),
						  modulo character varying(100),
						  icono character varying(255),
						  id_padre integer )
	);");
	}
}
