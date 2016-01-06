<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosBajas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        \DB::statement(" INSERT INTO beneficiarios.bajas(clave_beneficiario,periodo,motivo,mensaje)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,periodo,motivo,mensaje
			    FROM beneficiarios.beneficiarios_bajas limit 10000')
		    AS migracion(clave_beneficiario character varying(16),
				  periodo integer,
				  motivo smallint,
				  mensaje character varying(100))
	);");
    }
}
