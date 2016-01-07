<?php

use Illuminate\Database\Seeder;

class ComprobantesC extends Seeder
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

			\DB::statement(" INSERT INTO comprobantes.comprobantes(efector,numero_comprobante,tipo_comprobante,fecha_comprobante,fecha_recepcion,fecha_notificacion,fecha_liquidacion,fecha_debito_bancario,importe,importe_pagado,factura_debitada,concepto,lote)
		(
			SELECT *
			FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
			    'SELECT efector,numero_comprobante,tipo_comprobante,fecha_comprobante,fecha_recepcion,fecha_notificacion,fecha_liquidacion,fecha_debito_bancario,importe,importe_pagado,factura_debitada,concepto,lote
				    FROM comprobantes.c_".$prov." limit 10000')
			    AS migracion(efector character varying(14),
					  numero_comprobante character varying(50),
					  tipo_comprobante character(2),
					  fecha_comprobante date,
					  fecha_recepcion date,
					  fecha_notificacion date,
					  fecha_liquidacion date,
					  fecha_debito_bancario date,
					  importe numeric,
					  importe_pagado numeric,
					  factura_debitada character varying(50),
					  concepto text,
					  lote integer)			
		); ");
    	
    	}
	}
}
