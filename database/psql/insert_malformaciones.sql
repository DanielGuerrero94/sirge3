insert into efectores.datos_efector (id_efector, opera_malformaciones) select id_efector, opera_malformaciones from efectores.efectores join temporales.malformaciones using(siisa);
