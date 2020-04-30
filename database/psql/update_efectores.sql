alter table efectores.efectores add column hpgd character(1);
alter table efectores.efectores alter column hpgd set default 'N';
alter table efectores.efectores alter column recupera_costos set default 'S';
update efectores.efectores set hpgd = 'N';
update efectores.efectores set recupera_costos = 'S';
update efectores.efectores set hpgd = 'S' where siisa in (select siisa from temporales.hpgd h);
