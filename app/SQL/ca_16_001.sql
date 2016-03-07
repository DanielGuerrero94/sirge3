INSERT INTO indicadores.ca_16_001(id_provincia,periodo,volumen,descentralizacion)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008',
		    'select
		p.id_provincia				
		,(extract(year from now())::text || lpad(extract(mons from now())::text,2,''0''))::integer as periodo		
		, coalesce(round (prestaciones_desc :: numeric / prestaciones_fact * 100 , 2),0) as volumen
		, coalesce(round (( efectores_decentralizados ::numeric / cantidad_efectores) * 100 , 2),0) as descentralizacion
	from (
			select
				id_provincia
				, count (*) as cantidad_efectores
			from
				efectores.efectores e 
			left join
				efectores.datos_geograficos g on e.id_efector = g.id_efector
			where
				integrante = ''S''
			and 
				compromiso_gestion = ''S''
			group by
				id_provincia
		  ) e 
	left join (
					select
						id_provincia
						, count (*) as efectores_decentralizados
					from
						efectores.descentralizacion e left join
						efectores.datos_geograficos g on e.id_efector = g.id_efector left join
						efectores.efectores ef on e.id_efector = ef.id_efector
					where
						factura_descentralizada = ''S''
					and 
						integrante = ''S''
					and 
						compromiso_gestion = ''S''
					group by	
						id_provincia
			   
			   ) d 	on 	e.id_provincia = d.id_provincia
	left join (
				select
					provincia
					, count (*) as prestaciones_desc
				from (
					select dg.id_provincia as provincia, * from prestaciones.prestaciones pr left join sistema.lotes l on pr.lote = l.lote 
					left join efectores.efectores ef on ef.cuie = pr.efector
					left join efectores.datos_geograficos dg on ef.id_efector = dg.id_efector
					where l.id_estado = 1 
					and fecha_prestacion >= date_trunc(''year'', now())
					) prov
					where efector in (
						select cuie
						from
							efectores.efectores e left join
							efectores.descentralizacion d on e.id_efector = d.id_efector
						where
							factura_descentralizada = ''S''
							and integrante = ''S''
							and compromiso_gestion = ''S''
					)
				group by provincia
	) a on 	d.id_provincia = a.provincia
	left join (
		select
			provincia
			, count (*) as prestaciones_fact
		from (
			select dg.id_provincia as provincia from prestaciones.prestaciones pr left join sistema.lotes l on pr.lote = l.lote
			left join efectores.efectores ef on ef.cuie = pr.efector
			left join efectores.datos_geograficos dg on ef.id_efector = dg.id_efector
			where l.id_estado = 1 		
			and fecha_prestacion >= date_trunc(''year'', now())
			 ) provi
		
		group by provincia
	) b on a.provincia = b.provincia 
	--left join compromiso_anual.metas_descentralizacion md ON md.id_provincia = e.id_provincia AND md.year = extract (year from now())::integer
	right join
				geo.provincias p on e.id_provincia = p.id_provincia 	
	order by 
				e.id_provincia')
		    AS migracion(id_provincia character(2),
				  periodo integer,
				  volumen double precision,
				  descentralizacion double precision
				  )
	);

UPDATE indicadores.ca_16_001 SET datos_reportables = resultado
	FROM (
	SELECT fc.id_provincia as provincia, coalesce(round (( sum(cantidad_dr) ::numeric / sum(cantidad_total_dr)) * 100 , 2),0) as resultado 
	FROM 
		estadisticas.fc_009 fc
		WHERE 
			substring(fc.periodo::text,1,4)::integer = extract(year from now())			
		GROUP BY 1
	) as resultado
	WHERE id_provincia = provincia
	AND 
		periodo = (extract(year from now())::text || lpad(extract(mons from now())::text,2,'0'))::integer		


	