<?php

use Illuminate\Database\Seeder;

class PucoObrasSocialesProvinciales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO puco.obras_sociales_provinciales(codigo_osp, id_provincia)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
		    'SELECT codigo_osp, id_provincia
			    FROM puco.obras_sociales_provinciales')
		    AS migracion(codigo_osp integer,
  						 id_provincia character(2))			
	); ");
    }
}
