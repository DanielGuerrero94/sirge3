<?php

use Illuminate\Database\Seeder;

class PssCodigosTrazadoras extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement("INSERT INTO pss.codigos_trazadoras(codigo_prestacion,id_linea_cuidado,id_grupo_etario,id_trazadora)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT codigo_prestacion,id_linea_cuidado,id_grupo_etario,id_trazadora
			    FROM pss.codigos_trazadoras')
		    AS migracion(codigo_prestacion character varying(11),
				  id_linea_cuidado smallint,
				  id_grupo_etario smallint,
				  id_trazadora smallint)
	);");
    }
}
