<?php

use Illuminate\Database\Seeder;

class PucoProcesosObrasSociales extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO puco.procesos_obras_sociales(id_provincia,codigo_osp,periodo,puco,registros_in,registros_out)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_entidad,codigo_os,periodo,coalesce(puco,''N''),registros_insertados,registros_rechazados
			    FROM sistema.procesos_obras_sociales')
		    AS migracion( id_provincia character(2),
				  codigo_osp integer,
				  periodo integer,
				  puco character(1),
				  registros_in integer,
				  registros_out integer )			
	);  ");
    }
}
