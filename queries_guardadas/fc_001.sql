select
	extract (year from fecha_prestacion) :: text || lpad ( extract (month from fecha_prestacion) :: text , 2 , '0') as periodo
	, id_provincia
	, count(*)
	, sum(precio_unitario)
from
	prestaciones.prestaciones
group by 1,2
order by 1,2