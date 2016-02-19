<?php

use Illuminate\Database\Seeder;

class FondosFondosRechazos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			else
			{
				$prov = (string) $i;
			}

			\DB::statement(" INSERT INTO fondos.fondos_rechazos(efector,fecha_gasto,periodo,numero_comprobante,codigo_gasto,subcodigo_gasto,efector_cesion,monto,concepto,lote)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT efector,fecha_gasto,regexp_replace(periodo, ''-'', '''')::integer,numero_comprobante,codigo_gasto,subcodigo_gasto,efector_cesion,monto,concepto,lote
			    FROM aplicacion_fondos.a_".$prov." WHERE efector NOT IN (select cuie FROM efectores.efectores)')
		    AS migracion(efector character varying(14),
				  fecha_gasto date,
				  periodo integer,
				  numero_comprobante character varying(50),
				  codigo_gasto smallint,
				  subcodigo_gasto smallint,
				  efector_cesion character varying(255),
				  monto double precision,
				  concepto text,
				  lote integer)			
	); ");
		}
    	
    }
}
