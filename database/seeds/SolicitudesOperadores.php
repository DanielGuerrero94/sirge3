<?php

use Illuminate\Database\Seeder;

class SolicitudesOperadores extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO solicitudes.operadores(id_usuario, id_grupo, habilitado, created_at)
	(		
		SELECT id_usuario, 1, 'S', now()
			    FROM sistema.usuarios WHERE id_area = 1 AND id_entidad = 1	
	); ");
    }
}
