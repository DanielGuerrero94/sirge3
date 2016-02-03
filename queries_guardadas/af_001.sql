--DESDE SUMARDW

INSERT INTO estadisticas.uf_001(periodo,id_provincia,rubro,subrubro,monto)
	(
		SELECT *
		FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
		    'select
				replace(periodo , ''-'' , '''') ::int as periodo
				, id_provincia
				, codigo_gasto as rubro
				, subcodigo_gasto as subrubro
				, sum(monto)	
			from (
				select * from aplicacion_fondos.a_01 union all
				select * from aplicacion_fondos.a_02 union all
				select * from aplicacion_fondos.a_03 union all
				select * from aplicacion_fondos.a_04 union all
				select * from aplicacion_fondos.a_05 union all
				select * from aplicacion_fondos.a_06 union all
				select * from aplicacion_fondos.a_07 union all
				select * from aplicacion_fondos.a_08 union all
				select * from aplicacion_fondos.a_09 union all
				select * from aplicacion_fondos.a_10 union all
				select * from aplicacion_fondos.a_11 union all
				select * from aplicacion_fondos.a_12 union all
				select * from aplicacion_fondos.a_13 union all
				select * from aplicacion_fondos.a_14 union all
				select * from aplicacion_fondos.a_15 union all
				select * from aplicacion_fondos.a_16 union all
				select * from aplicacion_fondos.a_17 union all
				select * from aplicacion_fondos.a_18 union all
				select * from aplicacion_fondos.a_19 union all
				select * from aplicacion_fondos.a_20 union all
				select * from aplicacion_fondos.a_21 union all
				select * from aplicacion_fondos.a_22 union all
				select * from aplicacion_fondos.a_23 union all
				select * from aplicacion_fondos.a_24 ) f
				inner join efectores.efectores e
					on f.efector = e.cuie
				inner join efectores.datos_geograficos g
					on e.id_efector = g.id_efector	
				group by 1,2,3,4')
		    AS migracion( periodo integer,
				  id_provincia character(2),
				  rubro smallint,
				  subrubro smallint,
				  monto numeric
				 )			
	); 	