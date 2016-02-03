INSERT INTO estadisticas.fc_009(periodo,id_provincia,codigo_prestacion,cantidad_dr,cantidad_total_dr,cantidad)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'SELECT 
				extract(''year'' from fecha_prestacion)::varchar || lpad(extract(''mons'' from fecha_prestacion)::varchar, 2,''0'') as "PERIODO PRESTACION"
				--extract(''year'' from l.fecha_cierre_lote)::varchar || lpad(extract(''mons'' from l.fecha_cierre_lote)::varchar, 2,''0'') as "PRESENTADO"
				, p.id_provincia as "PROVINCIA"
				, p.codigo_prestacion				
				, sum(case 
					when datos_reportables IS NOT NULL 
					     AND datos_reportables NOT IN (''{"":""}'',''{" ":" "}'',''[""]'',''{"": ""}'',''{" ": " "}'') 
					     AND codigo_prestacion IN (''APA001A98'',''APA001X75'',''APA001X86'',''APA002A98'',''APA002X75'',''APA002X76'',''APA002X80'',''CTC001A97'',''CTC001T79'',''CTC001T82'',''CTC001T83'',''CTC002T79'',''CTC002T82'',''CTC002T83'',''CTC005W78'',''CTC006W78'',''CTC007O10.0'',''CTC007O10.4'',''CTC007O16'',''CTC007O24.4'',''CTC009A97'',''CTC010A97'',''CTC010W78'',''CTC017P05'',''CTC022O10.0'',''CTC022O10.4'',''CTC022O16'',''CTC022O24.4'',''IGR014A98'',''LBL119A97'',''LBL119W78'',''NTN002X75'',''PRP017A46'',''PRP017A97'',''PRP021A97'',''PRP021H86'')
					     THEN 1
					ELSE 0 END) as "DATOS REPORTABLES"
				, sum(case 
					when codigo_prestacion IN (''APA001A98'',''APA001X75'',''APA001X86'',''APA002A98'',''APA002X75'',''APA002X76'',''APA002X80'',''CTC001A97'',''CTC001T79'',''CTC001T82'',''CTC001T83'',''CTC002T79'',''CTC002T82'',''CTC002T83'',''CTC005W78'',''CTC006W78'',''CTC007O10.0'',''CTC007O10.4'',''CTC007O16'',''CTC007O24.4'',''CTC009A97'',''CTC010A97'',''CTC010W78'',''CTC017P05'',''CTC022O10.0'',''CTC022O10.4'',''CTC022O16'',''CTC022O24.4'',''IGR014A98'',''LBL119A97'',''LBL119W78'',''NTN002X75'',''PRP017A46'',''PRP017A97'',''PRP021A97'',''PRP021H86'')	
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