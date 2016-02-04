INSERT INTO estadisticas.fc_009(periodo,id_provincia,codigo_prestacion,cantidad_dr,cantidad_total_dr,cantidad)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT 
				extract(''year'' from fecha_prestacion)::varchar || lpad(extract(''mons'' from fecha_prestacion)::varchar, 2,''0'') as "PERIODO PRESTACION"				
				, p.id_provincia as "PROVINCIA"
				, p.codigo_prestacion				
				, sum(case 
					when datos_reportables IS NOT NULL 
					     AND datos_reportables NOT IN (''{"":""}'',''{" ":" "}'',''[""]'',''{"": ""}'',''{" ": " "}'') 
					     AND codigo_prestacion IN (select dr.codigo_prestacion FROM pss.codigos_datos_reportables dr)
					     THEN 1
					ELSE 0 END) as "DATOS REPORTABLES"
				, sum(case 
					when codigo_prestacion IN (select dr.codigo_prestacion FROM pss.codigos_datos_reportables dr)
				     THEN 1
				ELSE 0 END) as "TOTAL QUE DEBERIAN TENER D. REPORTABLES"
				, count(p.codigo_prestacion) as "TOTAL PRESTACIONES REPORTADAS"
				FROM prestaciones.prestaciones p
																		
				GROUP BY 1,2,3
				ORDER BY 1,2,3')
		    AS migracion( periodo integer,
				  id_provincia character(2),
				  codigo_prestacion character varying(11),
				  cantidad_dr bigint, 
				  cantidad_total_dr bigint,
				  cantidad bigint				 
				 )			
	); 	