TRUNCATE TABLE estadisticas.fc_008;

INSERT INTO estadisticas.fc_008(id_provincia,periodo,periodo_prestacion,codigo_prestacion,cantidad_dr,cantidad_total_dr,cantidad)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008',
		    'SELECT 
				p.id_provincia as "PROVINCIA"
				, extract(''year'' from l.fecha_cierre_lote)::varchar || lpad(extract(''mons'' from l.fecha_cierre_lote)::varchar, 2,''0'') as "PRESENTADO"
				, extract(''year'' from fecha_prestacion)::varchar || lpad(extract(''mons'' from fecha_prestacion)::varchar, 2,''0'') as "PERIODO PRESTACION"				
				, p.codigo_prestacion				
				, sum(case 
					when datos_reportables IS NOT NULL 
					     AND datos_reportables NOT IN (''{"":""}'',''{" ":" "}'',''[""]'',''{"": ""}'',''{" ": " "}'') 
					     AND codigo_prestacion IN (select dr.codigo_prestacion FROM pss.codigos_datos_reportables dr)
					     THEN 1
					ELSE 0 END) as "DATOS REPORTABLES"
				, sum(case 
					when codigo_prestacion IN (select codigo_prestacion FROM pss.codigos_datos_reportables)
				     THEN 1
				ELSE 0 END) as "TOTAL QUE DEBERIAN TENER D. REPORTABLES"
				, count(p.codigo_prestacion) as "TOTAL PRESTACIONES REPORTADAS"
				FROM prestaciones.prestaciones p
				INNER join sistema.lotes l
				on l.lote = p.lote 											
				AND l.id_estado = ''1''
				GROUP BY 1,2,3,4
				ORDER BY 1,2,3,4')
		    AS migracion( id_provincia character(2),
				  periodo integer,
				  periodo_prestacion integer,
				  codigo_prestacion character varying(11),
				  cantidad_dr bigint, 
				  cantidad_total_dr bigint,
				  cantidad bigint				 
				 )			
	); 	