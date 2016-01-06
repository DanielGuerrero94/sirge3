<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosCeb extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.ceb(clave_beneficiario,periodo,ceb,efector,fecha_ultima_prestacion,devenga_capita, devenga_cantidad_capita)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,periodo,ceb,efector,fecha_ultima_prestacion,devenga_capita, devenga_cantidad_capita
			    FROM beneficiarios.beneficiarios_ceb limit 10000')
		    AS migracion(clave_beneficiario character varying(16),
				  periodo integer,
				  ceb character(1),
				  efector character varying(14),
				  fecha_ultima_prestacion date,
				  devenga_capita character(1),
				  devenga_cantidad_capita smallint)			
	);");
    }
}
