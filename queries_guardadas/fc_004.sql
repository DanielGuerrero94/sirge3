select
	d.id_provincia
	, extract (year from fecha_prestacion) :: text || lpad (extract (month from fecha_prestacion) :: text , 2 , '0') as periodo
	, sexo
	, extract (year from age(fecha_prestacion , fecha_nacimiento))
	, count(p.codigo_prestacion)
	, sum(precio_unitario)
from
	prestaciones.prestaciones p
	left join efectores.efectores e
		on p.efector = e.cuie
	left join efectores.datos_geograficos d
		on e.id_efector = d.id_efector
	left join beneficiarios.beneficiarios b
		on p.clave_beneficiario = b.clave_beneficiario
where
	fecha_prestacion between '2015-01-01' and '2015-12-31'
group by 1,2,3,4
--limit 10