TRUNCATE TABLE estadisticas.fc_003;


INSERT INTO estadisticas.fc_003(id_provincia,periodo,id_linea_cuidado,cantidad,monto)
	(

SELECT *
		FROM dblink('dbname=sirge3 host=192.3.0.37 user=postgres password=BernardoCafe008','
			SELECT
				p.id_provincia
				, extract (year from fecha_prestacion) :: text || lpad (extract (month from fecha_prestacion) :: text , 2 , '0') as periodo
				, id_linea_cuidado
				, count(p.codigo_prestacion)
				, sum(precio_unitario)
			FROM
				prestaciones.prestaciones_completo p	
				LEFT JOIN pss.codigos_grupos c
					on p.codigo_prestacion = c.codigo_prestacion
			WHERE
				fecha_prestacion > ''2015-01-01''
			GROUP BY 1,2,3
		')
			AS migracion( id_provincia character(2),
				  periodo integer,
				  id_linea_cuidado integer,
				  cantidad integer,
				  monto numeric				  
			)						
);
