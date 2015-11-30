<?php

use Illuminate\Database\Seeder;

class CompromisoAnualMetasDescentralizacion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO compromiso_anual.metas_descentralizacion(id_provincia,primer_semestre,segundo_semestre,year)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_provincia,primer_semestre,segundo_semestre,anio
			    FROM compromiso_anual_2014.metas_descentralizacion')
		    AS migracion(id_provincia character(2),
				  primer_semestre double precision,
				  segundo_semestre double precision,
				  year integer)
	);");
    }
}
