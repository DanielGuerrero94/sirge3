TRUNCATE TABLE estadisticas.uf_001;

INSERT INTO estadisticas.uf_001(periodo,id_provincia,rubro,subrubro,monto)
	(
		SELECT *
		FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008',
		    'SELECT
				replace(periodo , ''-'' , '''') ::int AS periodo
				, id_provincia
				, codigo_gasto AS rubro
				, subcodigo_gasto AS subrubro
				, sum(monto)	
			FROM fondos.fondos f
				INNER JOIN efectores.efectores e
					ON f.efector = e.cuie
				INNER JOIN efectores.datos_geograficos g
					ON e.id_efector = g.id_efector	
				GROUP BY 1,2,3,4')
		    AS migracion( periodo integer,
				  id_provincia character(2),
				  rubro smallint,
				  subrubro smallint,
				  monto numeric
				 )			
	); 	