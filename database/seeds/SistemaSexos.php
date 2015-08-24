<?php

use Illuminate\Database\Seeder;

class SistemaSexos extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.sexos(id_sexo,sigla,descripcion)
	 (
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012$',
		    'SELECT id_sexo,sigla,descripcion
			    FROM sistema.sexos')
		    AS sirge_sexos(id_sexo integer,sigla char(1),descripcion character varying(50))
	 )
        			   	");
	}
}
