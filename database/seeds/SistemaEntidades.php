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
        \DB::statement("INSERT INTO sistema.entidades(id_entidad,id_tipo_entidad,id_region,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge2 host=192.6.0.66 user=postgres password=110678',
		    'SELECT id_entidad,id_tipo_entidad,id_region,descripcion
			    FROM sistema.entidades')
		    AS migracion(id_entidad character(2),
				  id_tipo_entidad integer,
				  id_region integer,
				  descripcion character varying(50))
	);");
    }
}
