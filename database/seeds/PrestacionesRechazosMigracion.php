<?php

use Illuminate\Database\Seeder;

class PrestacionesRechazosMigracion extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	for ($i = 17; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			else
			{
				$prov = (string) $i;
			}

        \DB::statement(" INSERT INTO prestaciones.rechazos_migracion(estado,efector,numero_comprobante,codigo_prestacion,subcodigo_prestacion,precio_unitario,fecha_prestacion,clave_beneficiario,tipo_documento,clase_documento,numero_documento,orden,lote,datos_reportables)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT estado,efector,numero_comprobante,codigo_prestacion,subcodigo_prestacion,precio_unitario,fecha_prestacion,clave_beneficiario,tipo_documento,clase_documento,numero_documento,orden,lote,datos_reportables::text
			    FROM prestaciones.p_".$prov." ')		
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
			WHERE 
			    	codigo_prestacion NOT IN (select codigo_prestacion FROM pss.codigos)
			    AND
			    	clave_beneficiario NOT IN (select clave_beneficiario FROM beneficiarios.beneficiarios)
			    AND 
			    	efector NOT IN (select cuie FROM efectores.efectores)
			    AND 
			    	lote NOT IN (select lote FROM sistema.lotes)			
	);");
		
		}
    }
}
