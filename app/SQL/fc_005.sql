TRUNCATE TABLE estadisticas.fc_005;


INSERT INTO estadisticas.fc_005(periodo,id_provincia,codigo_prestacion,grupo_etario,sexo,cantidad)
	(

SELECT *
		FROM dblink('dbname=sirge3 host=192.3.0.37 user=postgres password=BernardoCafe008','
			SELECT 
				extract (year FROM fecha_prestacion) :: text || lpad (extract (month FROM fecha_prestacion) :: text, 2 , ''0'') AS periodo
				, id_provincia
				, p.codigo_prestacion	
				, CASE
					WHEN extract (year FROM (age (fecha_prestacion,fecha_nacimiento))) <= 5 THEN ''A''
					WHEN extract (year FROM (age (fecha_prestacion,fecha_nacimiento))) BETWEEN 6 AND 9 THEN ''B''
					WHEN extract (year FROM (age (fecha_prestacion,fecha_nacimiento))) BETWEEN 10 AND 19 THEN ''C''
					WHEN extract (year FROM (age (fecha_prestacion,fecha_nacimiento))) BETWEEN 20 AND 64 THEN ''D''
				END AS sigla
				, b.sexo
				, count(*) AS cantidad
			FROM 
				prestaciones.prestaciones AS p
				INNER JOIN beneficiarios.beneficiarios AS b
					ON p.clave_beneficiario = b.clave_beneficiario
				
				/*
				inner join pss.codigos_ceb as c
					on p.codigo_prestacion = c.codigo_prestacion
				inner join pss.grupos_etarios as g
					on c.id_grupo_etario = g.id_grupo_etario
			where 
				age (fecha_prestacion , fecha_nacimiento) between edad_min :: interval and edad_max :: interval
				*/
			GROUP BY
				1,2,3,4,5
			ORDER BY
				1,2,3,4,5
		')
			AS migracion( periodo integer,
				  id_provincia character(2),
				  codigo_prestacion character(11),
				  grupo_etario character(1),
				  sexo character(1),
				  cantidad integer				  
			)
);
