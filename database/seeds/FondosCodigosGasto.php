<?php

use Illuminate\Database\Seeder;

class FondosCodigosGasto extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO fondos.codigos_gasto(codigo_gasto,descripcion)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT codigo_gasto,descripcion
			    FROM aplicacion_fondos.codigos_gastos')
		    AS migracion(codigo_gasto integer,
			         descripcion character varying(100))			
	);	");
    }
}
