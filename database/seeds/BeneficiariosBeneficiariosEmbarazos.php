<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosEmbarazos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         \DB::statement(" INSERT INTO beneficiarios.beneficiarios_embarazos(clave_beneficiario,id_embarazo,fecha_diagnostico_embarazo,semanas_embarazo,fecha_probable_parto,fecha_efectiva_parto,fum,periodo)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,id_embarazo,fecha_diagnostico_embarazo,semanas_embarazo,fecha_probable_parto,fecha_efectiva_parto,fum,periodo
			    FROM beneficiarios.beneficiarios_embarazos')
		    AS migracion(clave_beneficiario character varying(16),
				  id_embarazo integer,
				  fecha_diagnostico_embarazo date,
				  semanas_embarazo smallint,
				  fecha_probable_parto date,
				  fecha_efectiva_parto date,
				  fum date,
				  periodo integer)			
	);");
    }
}
