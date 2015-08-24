<?php

use Illuminate\Database\Seeder;

class SistemaTipoDocumento extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.tipo_documento(id_tipo_documento,tipo_documento,descripcion)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT id_tipo_documento,tipo_documento,descripcion
			    FROM sistema.tipo_documento')
		    AS sirge_tipo_documento(id_tipo_documento integer,tipo_documento char(3),descripcion character varying(100))
	 )
        			   	");
	}
}
