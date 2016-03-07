TRUNCATE TABLE estadisticas.fc_004;


INSERT INTO estadisticas.fc_004(id_provincia,periodo,sexo,edad,cantidad,monto)
	(

SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008','
			SELECT
				d.id_provincia
				, extract (year FROM fecha_prestacion) :: text || lpad (extract (month from fecha_prestacion) :: text , 2 , ''0'') AS periodo
				, sexo
				, extract (year FROM age(fecha_prestacion , fecha_nacimiento))
				, count(p.codigo_prestacion)
				, sum(precio_unitario)
			FROM
				prestaciones.prestaciones p
				LEFT JOIN efectores.efectores e
					ON p.efector = e.cuie
				LEFT JOIN efectores.datos_geograficos d
					ON e.id_efector = d.id_efector
				LEFT JOIN beneficiarios.beneficiarios b
					ON p.clave_beneficiario = b.clave_beneficiario
			WHERE
				fecha_prestacion > ''2015-01-01''
			GROUP BY 1,2,3,4
		')
			AS migracion( id_provincia character(2),
				  periodo integer,
				  sexo character(1),
				  edad integer,
				  cantidad integer,
				  monto numeric				  
			)
);