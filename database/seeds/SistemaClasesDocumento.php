<?php

use Illuminate\Database\Seeder;

class SistemaClasesDocumento extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.clases_documento(id,clase_documento,descripcion)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT id, clase_documento, descripcion
			    FROM sistema.clases_documento')
		    AS sirge_areas(id integer, clase_documento character (1), descripcion character varying(20) )
	 )
        			   	");
	}
}
