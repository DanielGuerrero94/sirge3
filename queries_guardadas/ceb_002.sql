select
	p.periodo
	, id_provincia_alta
	, count(*) as beneficiarios_registrados
	, sum(case when activo = 'S' then 1 else 0 end) as beneficiarios_activos
	, sum(case when ceb = 'S' then 1 else 0 end) as beneficiarios_ceb
from 
	beneficiarios.periodos p
	inner join beneficiarios.beneficiarios b 
		on p.clave_beneficiario = b.clave_beneficiario
	left join beneficiarios.ceb c 
		on p.clave_beneficiario || p.periodo :: text = c.clave_beneficiario || c.periodo :: text
			--and c.periodo = 200412
--where
	--p.periodo >=12
group by 1,2
order by 1,2