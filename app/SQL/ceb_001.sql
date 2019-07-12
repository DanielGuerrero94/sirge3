INSERT INTO estadisticas.ceb_001(periodo,id_provincia,codigo_prestacion,grupo_etario,sexo,cantidad)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.3.0.37 user=postgres password=BernardoCafe008',
		    'select 
				extract (year from fecha_prestacion) :: text || lpad (extract (month from fecha_prestacion) :: text, 2 , ''0'') as periodo
				, id_provincia
				, p.codigo_prestacion
				, substring(g.sigla from 1 for 1) as grupo_etario
				, b.sexo
				, count(*) as cantidad
			from 
				prestaciones.prestaciones as p
				inner join beneficiarios.beneficiarios as b
					on p.clave_beneficiario = b.clave_beneficiario
				inner join pss.codigos_ceb as c
					on p.codigo_prestacion = c.codigo_prestacion
				inner join pss.grupos_etarios as g
					on c.id_grupo_etario = g.id_grupo_etario

			where 
				age (fecha_prestacion , fecha_nacimiento) between edad_min :: interval and edad_max :: interval
			group by
				1,2,3,4,5
			order by
				1,2,3,4,5')
		    AS migracion( periodo integer,
				  id_provincia character(2),
				  codigo_prestacion character varying(11),
				  grupo_etario character(1),
				  sexo character(1),
				  cantidad bigint
				 )			
	); 	
