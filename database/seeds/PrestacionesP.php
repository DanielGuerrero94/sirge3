<?php

use Illuminate\Database\Seeder;

class PrestacionesP extends Seeder
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

			\DB::statement(" INSERT INTO prestaciones.prestaciones(estado,efector,numero_comprobante,codigo_prestacion,subcodigo_prestacion,precio_unitario,fecha_prestacion,clave_beneficiario,tipo_documento,clase_documento,numero_documento,orden,lote,datos_reportables)
	(
		SELECT estado,efector,numero_comprobante,codigo_prestacion,subcodigo_prestacion,precio_unitario,fecha_prestacion,clave_beneficiario,tipo_documento,clase_documento,numero_documento,orden,lote,datos_reportables::jsonb
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT estado,efector,numero_comprobante,codigo_prestacion,subcodigo_prestacion,precio_unitario,fecha_prestacion,b.clave_beneficiario,p.tipo_documento,p.clase_documento,p.numero_documento,orden,lote,datos_reportables::text
		    FROM prestaciones.p_" . $prov . " p INNER JOIN beneficiarios.beneficiarios b ON p.clave_beneficiario = b.clave_beneficiario LIMIT 100')		
	    AS migracion(estado character(1),
			  efector character varying(14),
			  numero_comprobante character varying(50),
			  codigo_prestacion character varying(11),
			  subcodigo_prestacion character varying(3),
			  precio_unitario double precision,
			  fecha_prestacion date,
			  clave_beneficiario character varying(16),
			  tipo_documento character(3),
			  clase_documento character(1),
			  numero_documento character varying(14),
			  orden smallint,
			  lote integer,
			  datos_reportables character varying)					
	);");
			
		}
    }
}
