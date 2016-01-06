<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosIndigenas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.indigenas(clave_beneficiario,declara_indigena,id_lengua, id_tribu)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,declara_indigena,id_lengua,id_tribu
			    FROM beneficiarios.beneficiarios_indigenas limit 10000')
		    AS migracion(clave_beneficiario character varying(16),
				  declara_indigena character(1),
				  id_lengua smallint,
				  id_tribu smallint)			
	); 	");
    }
}
