<?php

use Illuminate\Database\Seeder;

class EfectoresTipoEfecotr extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.tipo_efector(id_tipo_efector,sigla,descripcion)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_tipo_efector,sigla,descripcion
		    FROM efectores.tipo_efector')
	    AS migracion(id_tipo_efector integer,
  sigla character varying(4),
  descripcion character varying(50))
);");
	}
}
