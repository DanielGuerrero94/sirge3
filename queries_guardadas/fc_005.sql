select 
--	* 
--	, age (fecha_prestacion , fecha_nacimiento) as edad
--	, 
	extract (year from fecha_prestacion) :: text || lpad (extract (month from fecha_prestacion) :: text, 2 , '0') as periodo
	, id_provincia
	, p.codigo_prestacion
	--, substring(g.sigla from 1 for 1) as sigla
	, case
		when extract (year from (age (fecha_prestacion,fecha_nacimiento))) <= 5 then 'A'
		when extract (year from (age (fecha_prestacion,fecha_nacimiento))) between 6 and 9 then 'B'
		when extract (year from (age (fecha_prestacion,fecha_nacimiento))) between 10 and 19 then 'C'
		when extract (year from (age (fecha_prestacion,fecha_nacimiento))) between 20 and 64 then 'D'
	end as sigla
	, b.sexo
	, count(*) as cantidad
from 
	prestaciones.prestaciones as p
	inner join beneficiarios.beneficiarios as b
		on p.clave_beneficiario = b.clave_beneficiario
	
	/*
	inner join pss.codigos_ceb as c
		on p.codigo_prestacion = c.codigo_prestacion
	inner join pss.grupos_etarios as g
		on c.id_grupo_etario = g.id_grupo_etario
where 
	age (fecha_prestacion , fecha_nacimiento) between edad_min :: interval and edad_max :: interval
	*/
group by
	1,2,3,4,5
order by
	1,2,3,4,5