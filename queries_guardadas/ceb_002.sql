--DESDE SUMARDW

INSERT INTO estadisticas.ceb_002(periodo,id_provincia,beneficiarios_registrados,beneficiarios_activos,beneficiarios_ceb)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008',
		    'select
				p.periodo
				, id_provincia_alta
				, count(*) as beneficiarios_registrados
				, sum(case when activo = ''S'' then 1 else 0 end) as beneficiarios_activos
				, sum(case when ceb = ''S'' then 1 else 0 end) as beneficiarios_ceb
			from 
				beneficiarios.periodos p				
				inner join beneficiarios.beneficiarios b 
					on p.clave_beneficiario = b.clave_beneficiario
				left join beneficiarios.ceb c 				
					on p.clave_beneficiario = c.clave_beneficiario AND p.periodo =  c.periodo			
			group by 1,2
			order by 1,2')
		    AS migracion( periodo integer,
				  id_provincia character(2),
				  beneficiarios_registrados integer,
				  beneficiarios_activos integer,
				  beneficiarios_ceb integer
				 )			
	); 	
