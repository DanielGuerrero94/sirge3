<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosContacto extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.contacto(clave_beneficiario,telefono,celular,email,modificado)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,telefono,celular,email,modificado
			    FROM beneficiarios.beneficiarios_contacto')
		    AS migracion(clave_beneficiario character varying(16),
				  telefono character varying(50),
				  celular character varying(50),
				  email character varying(50),
				  modificado smallint)			
	);");
    }
}
