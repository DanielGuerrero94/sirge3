<?php

use Illuminate\Database\Seeder;

class SistemaEntidades extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO sistema.entidades(id,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.118 user=postgres password=LatinoSandwich007',
		    'SELECT id,descripcion
			    FROM sistema.entidades')
		    AS migracion(id character(2),				  				  
				  descripcion character varying(50))
	);");
    }
}
