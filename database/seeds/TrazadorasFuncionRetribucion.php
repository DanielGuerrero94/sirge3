<?php

use Illuminate\Database\Seeder;

class TrazadorasFuncionRetribucion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO trazadoras.funcion_retribucion(id_provincia,id_trazadora,tasa_cobertura,retribucion_minima,meta,retribucion_maxima,denominador_casos,tasa_cobertura_minima_casos,meta_casos)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_provincia,id_trazadora,tasa_cobertura,retribucion_minima,meta,retribucion_maxima,denominador_casos,tasa_cobertura_minima_casos,meta_casos
			    FROM trazadoras.funcion_retribucion')
		    AS migracion(id_provincia character varying(2),
				  id_trazadora smallint,
				  tasa_cobertura double precision,
				  retribucion_minima double precision,
				  meta double precision,
				  retribucion_maxima double precision,
				  denominador_casos double precision,
				  tasa_cobertura_minima_casos double precision,
				  meta_casos double precision)
	);");
	}
}
