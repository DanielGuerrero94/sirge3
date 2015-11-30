<?php

use Illuminate\Database\Seeder;

class IndecPoblacionDepartamentos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO indec.poblacion_departamentos(id_provincia, id_departamento, habitantes, habitantes_sumar)
	(
		SELECT *
		FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
		    'SELECT id_provincia, id_departamento, habitantes, coalesce(habitantes_sumar,0)
			FROM
				indec.poblacion_departamentos;')
		    AS migracion(id_provincia char(2),
				 id_departamento char(3),
				 habitantes integer,
				 habitantes_sumar integer
				)
	);  ");
    }
}
