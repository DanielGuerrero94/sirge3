TRUNCATE TABLE estadisticas.fc_006;


INSERT INTO estadisticas.fc_006 (periodo,id_provincia,codigo_prestacion,id_grupo_etario,sexo,cantidad)
(
	SELECT *
FROM dblink('dbname=sirge3 host=192.6.0.37 user=postgres password=BernardoCafe008','
        SELECT
                        (extract (year FROM fecha_prestacion) :: text || lpad (extract (month FROM fecha_prestacion) :: text, 2 , '0'))::integer as periodo
                        , dg.id_provincia AS id_provincia
                        , p.codigo_prestacion
                        , b.sexo
                        , ge.id_grupo_etario
                        , count(*)
                FROM
                        prestaciones.prestaciones p
                        INNER JOIN beneficiarios.beneficiarios b ON p.clave_beneficiario = b.clave_beneficiario
                        INNER JOIN pss.codigos_grupos cg ON p.codigo_prestacion = cg.codigo_prestacion
                        INNER JOIN pss.grupos_etarios ge ON cg.id_grupo_etario = ge.id_grupo_etario
                        INNER JOIN efectores.efectores e ON e.cuie = p.cuie
                        INNER JOIN efectores.datos_geograficos dg ON e.id_efector = dg.id_efector
                WHERE
                        fecha_prestacion BETWEEN fecha_nacimiento + ge.edad_min::interval AND fecha_nacimiento + ge.edad_max::interval
                GROUP BY
                        1,2,3,4,5
')
                        AS migracion( periodo integer,
                                  id_provincia character(2),                                  
                                  codigo_prestacion character(11),
                                  id_grupo_etario integer,
                                  sexo character(1),
                                  cantidad integer                           
                        )        
)