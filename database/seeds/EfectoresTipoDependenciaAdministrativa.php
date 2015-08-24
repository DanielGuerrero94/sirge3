<?php

use Illuminate\Database\Seeder;

class EfectoresTipoDependenciaAdministrativa extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement("INSERT INTO efectores.tipo_dependencia_administrativa(id_dependencia_administrativa,sigla,descripcion)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_dependencia_administrativa,sigla,descripcion
		    FROM efectores.tipo_dependencia_administrativa')
	    AS migracion(id_dependencia_administrativa integer,
  sigla character varying(4),
  descripcion character varying(50))
);");
	}
}
