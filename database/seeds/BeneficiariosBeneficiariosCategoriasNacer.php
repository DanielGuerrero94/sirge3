<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosCategoriasNacer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.beneficiarios_categorias_nacer(clave_beneficiario,periodo,tipo_categoria)
	(
		SELECT clave_beneficiario,periodo,tipo_categoria
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,periodo,tipo_categoria
			    FROM beneficiarios.beneficiarios_categorias_nacer')
		    AS migracion(clave_beneficiario character varying(16),
				 periodo integer,
				 tipo_categoria smallint)	
				 	
	);");
    }
}
