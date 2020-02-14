--Consigo que prestaciones tengo que actualizar
/*
select de.id_efector, n.categoria_iam from efectores.datos_efector de join (
select id_efector,categoria_iam from temporales.iam join efectores.efectores using(siisa)
where siisa not in (
'10180212139042',
'10140142131259',
'10420072153032',
'10140142131160',
'10860842193424',
'10140142031239',
'10460842155019'
)
) as n on de.id_efector = n.id_efector;
*/

update efectores.datos_efector set categoria_iam = 'III' where id_efector = 272;

insert into efectores.datos_efector (id_efector, categoria_iam)
select id_efector,categoria_iam from temporales.iam join efectores.efectores using(siisa)
where siisa not in (
'10180212139042',
'10140142131259',
'10420072153032',
'10140142131160',
'10860842193424',
'10140142031239',
'10460842155019'
) and id_efector != 272
