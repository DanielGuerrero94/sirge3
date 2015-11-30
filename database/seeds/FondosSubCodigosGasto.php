<?php

use Illuminate\Database\Seeder;

class FondosSubCodigosGasto extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO fondos.subcodigos_gasto(codigo_gasto,subcodigo_gasto,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT codigo_gasto,subcodigo_gasto,descripcion
			    FROM aplicacion_fondos.subcodigos_gastos')
		    AS migracion(codigo_gasto integer,
				  subcodigo_gasto integer,
				  descripcion character varying(100))			
	);	");
    }
}
