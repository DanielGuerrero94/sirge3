<?php

use Illuminate\Database\Seeder;

class SistemaMenues extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO sistema.menues(id_menu,descripcion)
 (
	SELECT *
	FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
	    'SELECT *
		    FROM sistema.menues')
	    AS sirge_menues(id_menu integer, descripcion character varying(100))
 )
        			   	");
	}
}
