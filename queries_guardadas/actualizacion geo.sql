-- alter table efectores.departamentos set schema geo;
-- alter table efectores.localidades set schema geo;
-- alter table efectores.entidades set schema geo;

-- ALTER TABLE efectores.datos_geograficos DROP CONSTRAINT fkey_id_departamento_datos_geograficos;
-- ALTER TABLE efectores.datos_geograficos DROP CONSTRAINT fkey_id_localidad_datos_geograficos;

-- update	efectores.datos_geograficos as g
-- set	id_departamento = geo.id
-- from	geo.departamentos geo
-- where	g.id_provincia || g.id_departamento = geo.id_provincia || geo.id_departamento

-- update 	efectores.datos_geograficos as g
-- set 	id_localidad = geo.id
-- from 	geo.localidades geo
-- where g.id_provincia || g.id_departamento || g.id_localidad = geo.id_provincia || geo.id_departamento || geo.id_localidad