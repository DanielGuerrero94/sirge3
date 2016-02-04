<?php

use Illuminate\Database\Seeder;

class CompromisoAnualMetasDependenciasSanitarias extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO compromiso_anual.metas_dependencias_sanitarias(id_provincia,primer_cuatrimestre,segundo_cuatrimestre,tercer_cuatrimestre,year)
	(
		SELECT *
		FROM dblink('dbname=sumardw host=192.6.0.118 user=postgres password=LatinoSandwich007',
		    'SELECT id_provincia,primer_cuatrimestre,segundo_cuatrimestre,tercer_cuatrimestre,year
			    FROM compromiso_anual.metas_dependencias_sanitarias')
		    AS migracion(id_provincia character(2),
				  primer_cuatrimestre double precision,
				  segundo_cuatrimestre double precision,
				  tercer_cuatrimestre double precision,
				  year integer)
	);");
    }
}
