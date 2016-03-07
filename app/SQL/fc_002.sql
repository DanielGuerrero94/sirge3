TRUNCATE TABLE estadisticas.fc_002;

INSERT INTO estadisticas.fc_002(periodo,id_provincia,codigo_prestacion,cantidad,monto)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008','
			SELECT
				extract (year from fecha_prestacion) :: text || lpad ( extract (month from fecha_prestacion) :: text , 2 , ''0'') as periodo
				, id_provincia
				, codigo_prestacion
				, count(fecha_prestacion)
				, sum(precio_unitario)
			FROM prestaciones.prestaciones_completo

			group by 1,2,3
			order by 1,2,3	
		')
			AS migracion( periodo integer,
				  id_provincia character(2),
				  codigo_prestacion character(11),
				  cantidad integer,
				  monto numeric				  
			)						
	); 	
