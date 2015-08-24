<?php

use Illuminate\Database\Seeder;

class EfectoresCategoriasPpac extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.categorias_ppac(id_categoria,categoria)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_categoria,categoria
		    FROM efectores.categorias_ppac')
	    AS migracion(id_categoria integer,
  categoria character varying(4))
);");
	}
}
