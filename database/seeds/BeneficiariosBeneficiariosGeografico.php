<?php

use Illuminate\Database\Seeder;

class BeneficiariosBeneficiariosGeografico extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.geografico(clave_beneficiario,calle,numero,manzana,piso,departamento,calle_1,calle_2,barrio,municipio,id_departamento,id_localidad,id_provincia,codigo_postal)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,calle,numero,manzana,piso,departamento,calle_1,calle_2,barrio,municipio,id_departamento,id_localidad,id_provincia,codigo_postal
			    FROM beneficiarios.beneficiarios_geografico limit 10000')
		    AS migracion(clave_beneficiario character varying(16),
				  calle character varying(100),
				  numero character varying(10),
				  manzana character varying(5),
				  piso character varying(3),
				  departamento character varying(3),
				  calle_1 character varying(100),
				  calle_2 character varying(100),
				  barrio character varying(100),
				  municipio character varying(100),
				  id_departamento character varying(3),
				  id_localidad character varying(3),
				  id_provincia character varying(2),
				  codigo_postal character varying(8))			
	); 	");
    }
}
