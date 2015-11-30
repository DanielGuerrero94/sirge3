<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosScore extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.beneficiarios_score(clave_beneficiario,score_riesgo)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,score_riesgo
			    FROM beneficiarios.beneficiarios_score')
		    AS migracion(clave_beneficiario character varying(16),
				  score_riesgo smallint)			
	); 	");
    }
}
