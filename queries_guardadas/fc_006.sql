INSERT INTO estadisticas.fc_006 (periodo,id_provincia,codigo_prestacion,id_grupo_etario,sexo,cantidad)
(
	select
                        (extract (year from fecha_prestacion) :: text || lpad (extract (month from fecha_prestacion) :: text, 2 , '0'))::integer as periodo
                        , left (p.clave_beneficiario,2)::character(2) as id_provincia
                        , p.codigo_prestacion
                        , b.sexo
                        , ge.id_grupo_etario
                        , count(*)
                from
                        prestaciones.prestaciones p
                        inner join beneficiarios.beneficiarios b on p.clave_beneficiario = b.clave_beneficiario
                        inner join pss.codigos_grupos cg on p.codigo_prestacion = cg.codigo_prestacion
                        inner join pss.grupos_etarios ge on cg.id_grupo_etario = ge.id_grupo_etario
                where
                        fecha_prestacion BETWEEN fecha_nacimiento + ge.edad_min::interval AND fecha_nacimiento + ge.edad_max::interval
                group by
                        1,2,3,4,5
)