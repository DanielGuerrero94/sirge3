--DESDE SUMARDW

INSERT INTO estadisticas.fc_002(periodo,id_provincia,codigo_prestacion,cantidad,monto)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'select
				extract (year from fecha_prestacion) :: text || lpad ( extract (month from fecha_prestacion) :: text , 2 , ''0'') as periodo
				, id_provincia
				, codigo_prestacion
				, count(fecha_prestacion)
				, sum(precio_unitario)
			from (
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_01 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_02 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_03 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_04 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_05 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_06 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_07 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_08 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_09 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_10 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_11 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_12 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_13 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_14 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_15 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_16 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_17 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_18 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_19 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_20 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_21 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_22 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_23 union all
							select clave_beneficiario,fecha_prestacion,precio_unitario,codigo_prestacion from prestaciones.p_24 			
			) p inner join efectores.efectores e ON p.efector = e.cuie
					inner join efectores.datos_geograficos g ON e.id_efector = g.id_efector
			group by 1,2,3
			order by 1,2,3')
		    AS migracion( periodo integer,
				  id_provincia character(2),
				  codigo_prestacion character varying(11), 
				  cantidad integer,
				  monto numeric				  
				 )			
	); 	
