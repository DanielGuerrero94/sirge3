select count(*) from efectores.efectores e right join efectores.listadoestablecsumarmen10k el using(cuie) where nombre is null;

alter table efectores.efectores add column menor_10k character(1);

update efectores.efectores set menor_10k = 'S' where cuie in (select cuie from efectores.listadoestablecsumarmen10k);

update efectores.efectores set menor_10k = 'N' where menor_10k is null;