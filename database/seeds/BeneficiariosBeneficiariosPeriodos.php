<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosPeriodos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.periodos(clave_beneficiario,periodo,activo,efector_asignado,efector_habitual,id_ingreso,embarazo)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,periodo,activo,efector_asignado,efector_habitual,id_ingreso,embarazo
			    FROM beneficiarios.beneficiarios_periodos limit 10000')
		    AS migracion(clave_beneficiario character varying(16),
				  periodo integer,
				  activo character(1),
				  efector_asignado character varying(14),
				  efector_habitual character varying(14),
				  id_ingreso integer,
				  embarazo character(1))			
	); 	");
    }
}
