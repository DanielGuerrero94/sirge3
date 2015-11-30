<?php

use Illuminate\Database\Seeder;

class DdjjSirge extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement(" INSERT INTO ddjj.sirge(id_impresion,fecha_impresion,lote)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT
				row_number() over()
				, date_trunc (''second'' , fecha_impresion_ddjj )
				, array_agg(lote)		
			FROM
				sistema.impresiones_ddjj GROUP BY 2;')
		    AS migracion(id_impresion integer,
				fecha_impresion timestamp without time zone,
				lote integer[])
	); ");
    }
}
