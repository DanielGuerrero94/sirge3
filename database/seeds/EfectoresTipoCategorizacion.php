<?php

use Illuminate\Database\Seeder;

class EfectoresTipoCategorizacion extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.tipo_categorizacion(id_categorizacion,sigla,descripcion)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_categorizacion,sigla,descripcion
		    FROM efectores.tipo_categorizacion')
	    AS migracion(  id_categorizacion integer,sigla character varying(6),descripcion character varying(100))
);");
	}
}
