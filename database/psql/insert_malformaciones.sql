insert into efectores.datos_efector (id_efector, opera_malformaciones) select id_efector, opera_malformaciones from e
fectores.efectores join temporales.malformaciones using(siisa);
