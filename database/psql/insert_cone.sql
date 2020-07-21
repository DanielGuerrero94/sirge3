--Hago un update de los que ya tienen dato de malformacion o iam
/*
update efectores.datos_efector de
set cumple_cone = tc.cumple_cone,
categoria_maternidad = tc.categoria_maternidad,
categoria_neonatologia = tc.categoria_neonatologia
from (select e.id_efector, cumple_cone, categoria_maternidad, categoria_neonatologia from efectores.efectores e join temporales.cone c on c.siisa = e.siisa
where e.siisa not in ('10180212139042','10065472100379')
) as tc 
where tc.id_efector = de.id_efector;
*/

insert into efectores.datos_efector (id_efector, cumple_cone, categoria_maternidad, categoria_neonatologia)
select e.id_efector, c.cumple_cone, c.categoria_maternidad, c.categoria_neonatologia from efectores.efectores e join temporales.cone c on c.siisa = e.siisa left join temporales.iam i on i.siisa = c.siisa
where e.siisa not in ('10180212139042','10065472100379') and i.categoria_iam is null
