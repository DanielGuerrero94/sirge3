<?php

use Illuminate\Database\Seeder;

class BeneficiariosResumenBeneficiarios extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO beneficiarios.resumen_beneficiarios(id_provincia,periodo,beneficiarios,beneficiarios_ceb,mujeres,mujeres_ceb,hombres,hombres_ceb,beneficiarios_05,beneficiarios_69,beneficiarios_1019,beneficiarios_2064)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT id_provincia,periodo,beneficiarios,beneficiarios_ceb,mujeres,mujeres_ceb,hombres,hombres_ceb,beneficiarios_05,beneficiarios_69,beneficiarios_1019,beneficiarios_2064
			    FROM beneficiarios.resumen_beneficiarios')
		    AS migracion(id_provincia character(2),
				  periodo integer,
				  beneficiarios integer,
				  beneficiarios_ceb integer,
				  mujeres integer,
				  mujeres_ceb integer,
				  hombres integer,
				  hombres_ceb integer,
				  beneficiarios_05 integer,
				  beneficiarios_69 integer,
				  beneficiarios_1019 integer,
				  beneficiarios_2064 integer)			
	);  ");
    }
}
