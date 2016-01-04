<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosPeriodosYCeb2015 extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.periodos_y_ceb_2015(clave_beneficiario,periodo,activo,efector_asignado,ceb)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,periodo,activo,efector_asignado,ceb
			    FROM beneficiarios.periodos_y_ceb_2015')
		    AS migracion(clave_beneficiario character varying(16),
				  periodo integer,
				  activo character(1),
				  efector_asignado character varying(14),
				  ceb character(1))			
	);  ");
    }
}
