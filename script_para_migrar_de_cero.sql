--QUERY PARA CORRER EN EL MOTOR

--DROP SCHEMA aplicacion_fondos_old CASCADE;
DROP SCHEMA beneficiarios CASCADE;
DROP SCHEMA comprobantes CASCADE;
--DROP SCHEMA comprobantes_old CASCADE;
DROP SCHEMA compromiso_anual CASCADE;
DROP SCHEMA consultas CASCADE;
DROP SCHEMA ddjj CASCADE;
DROP SCHEMA efectores CASCADE;
DROP SCHEMA fondos CASCADE;
DROP SCHEMA geo CASCADE;
DROP SCHEMA indicadores CASCADE;
DROP SCHEMA logs CASCADE;
DROP SCHEMA mobile CASCADE;
DROP SCHEMA osp CASCADE;
DROP SCHEMA prestaciones CASCADE;
--DROP SCHEMA prestaciones_old CASCADE;
DROP SCHEMA pss CASCADE;
DROP SCHEMA puco CASCADE;
DROP SCHEMA sistema CASCADE;
DROP SCHEMA solicitudes CASCADE;
DROP SCHEMA graficos CASCADE;
DROP SCHEMA chat CASCADE;
DROP SCHEMA diccionarios CASCADE;

TRUNCATE public.migrations;

--LUEGO DE EJECUTAR, VOLVER A CORRER 'php artisan migrate'

SELECT 'SELECT SETVAL(' ||
       quote_literal(quote_ident(PGT.schemaname) || '.' || quote_ident(S.relname)) ||
       ', COALESCE(MAX(' ||quote_ident(C.attname)|| '), 1) ) FROM ' ||
       quote_ident(PGT.schemaname)|| '.'||quote_ident(T.relname)|| ';'
FROM pg_class AS S,
     pg_depend AS D,
     pg_class AS T,
     pg_attribute AS C,
     pg_tables AS PGT
WHERE S.relkind = 'S'
    AND S.oid = D.objid
    AND D.refobjid = T.oid
    AND D.refobjid = C.attrelid
    AND D.refobjsubid = C.attnum
    AND T.relname = PGT.tablename
ORDER BY S.relname;