TRUNCATE TABLE estadisticas.fc_001;


INSERT INTO estadisticas.fc_001(periodo,id_provincia,cantidad,monto)
	(		
	    SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008','
	    SELECT
				extract (year from fecha_prestacion) :: text || lpad ( extract (month from fecha_prestacion) :: text , 2 , ''0'') as periodo
				, id_provincia
				, count(fecha_prestacion)
				, sum(precio_unitario)
			FROM  prestaciones.prestaciones_completo p
			group by 1,2
			order by 1,2')
			AS migracion( periodo integer,
				  id_provincia character(2),
				  cantidad integer,
				  monto numeric				  
			)				
	); 	
