select
	g.id_provincia
	, extract (year from fecha_prestacion) :: text || lpad (extract (month from fecha_prestacion) :: text , 2 , '0') as periodo
	, id_linea_cuidado
	, count(p.codigo_prestacion)
	, sum(precio_unitario)
from
	prestaciones.prestaciones p
	left join efectores.efectores e
		on p.efector = e.cuie
	left join efectores.datos_geograficos g
		on e.id_efector = g.id_efector
	left join pss.codigos_grupos c
		on p.codigo_prestacion = c.codigo_prestacion
where
	fecha_prestacion between '2015-01-01' and '2015-12-31'
group by 1,2,3
--limit 10