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
		SELECT clave_beneficiario_n,calle_n,numero_n,manzana_n,piso_n,departamento_n,calle_1_n,calle_2_n,barrio_n,municipio_n,
		(SELECT id FROM geo.departamentos WHERE id_departamento = id_departamento_n AND id_provincia = id_provincia_n) as id_departamento ,
		(SELECT id FROM geo.localidades WHERE id_departamento = id_departamento_n AND id_provincia = id_provincia_n AND id_localidad = id_localidad_n) as id_localidad,id_provincia_n,codigo_postal_n
		
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT clave_beneficiario,calle,numero,manzana,piso,departamento,calle_1,calle_2,barrio,municipio,id_departamento,id_localidad,id_provincia,codigo_postal
			    FROM beneficiarios.beneficiarios_geografico')
		    AS migracion(clave_beneficiario_n character varying(16),
				  calle_n character varying(100),
				  numero_n character varying(10),
				  manzana_n character varying(5),
				  piso_n character varying(3),
				  departamento_n character varying(3),
				  calle_1_n character varying(100),
				  calle_2_n character varying(100),
				  barrio_n character varying(100),
				  municipio_n character varying(100),
				  id_departamento_n character varying(3),
				  id_localidad_n character varying(3),
				  id_provincia_n character varying(2),
				  codigo_postal_n character varying(8))			
	); 	");
    }
}
