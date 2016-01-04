<?php

use Illuminate\Database\Seeder;

class DiccionariosDiccionario extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	\DB::statement(" INSERT INTO diccionarios.diccionario(padron,orden,campo,tipo,obligatorio,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
		    'SELECT padron,orden,campo,tipo,obligatorio,descripcion
			    FROM diccionarios.diccionario')
		    AS migracion(padron integer,
						  orden integer,
						  campo character varying,
						  tipo character varying,
						  obligatorio character(2),
						  descripcion text)
	); ");       
    }
}
