BEGIN;
-- UPDATES PREVIOS

-- Cambio los valores mal escritos
UPDATE
    efectores.tmp_chaco_10_2020
SET
    sigla_tipo_efector = 'PSB'
WHERE
    sigla_tipo_efector = 'P.S.B';

UPDATE
    efectores.tmp_chaco_10_2020
SET
    sigla_tipo_efector = 'ADM'
WHERE
    sigla_tipo_efector = 'ADM.';


-- Agrego constraints que se usan en la base actual para poder hacer el insert o update en caso de que exista
ALTER TABLE efectores.convenio_administrativo
DROP CONSTRAINT IF EXISTS efectores_convenio_administrativo_id_efector_unique;

ALTER TABLE efectores.convenio_administrativo
ADD CONSTRAINT efectores_convenio_administrativo_id_efector_unique UNIQUE (id_efector);

ALTER TABLE efectores.compromiso_gestion
DROP CONSTRAINT IF EXISTS efectores_compromiso_gestion_id_efector_unique;

ALTER TABLE efectores.compromiso_gestion
ADD CONSTRAINT efectores_compromiso_gestion_id_efector_unique UNIQUE (id_efector);


-- Borro los telefonos que van a molestar la constraint nueva (están repetidos)
DELETE FROM efectores.telefonos WHERE id_telefono IN (8887,4811,218,4713,4816,5077,5060,4970,4885,2115,5003,4917,4891,4900,4899,5145,5149,8757);

ALTER TABLE efectores.telefonos
DROP CONSTRAINT IF EXISTS efectores_telefonos_id_efector_numero_telefono_unique;

ALTER TABLE efectores.telefonos
ADD CONSTRAINT efectores_telefonos_id_efector_numero_telefono_unique UNIQUE (id_efector, numero_telefono);


-- Borro los emails que van a molestar la constraint nueva (están repetidos)
DELETE FROM efectores.email WHERE id_email IN (3697,3175,3302,2809,5170,3057,3056,2724,5447,2858,3051,3050,58,2745,2606,2545,2694,2741,2760,3247,1997,2876,2878,2873,2872,3139,3136,2708,2663,2701,2700,2664,2994,2998,2865,6180,2814,2928,3020,2764,2812);

ALTER TABLE efectores.email
DROP CONSTRAINT IF EXISTS efectores_email_id_efector_email_unique;

ALTER TABLE efectores.email
ADD CONSTRAINT efectores_email_id_efector_email_unique UNIQUE (id_efector, email);


-- INSERTS O UPDATES
-- Insert O Update efectores.efectores
INSERT INTO
    efectores.efectores AS e
    (
        cuie,
        siisa,
        nombre,
        domicilio,
        codigo_postal,
        denominacion_legal,
        id_tipo_efector,
        rural,
        cics,
        id_categorizacion,
        id_dependencia_administrativa,
        dependencia_sanitaria,
        compromiso_gestion,
        id_estado,
        hcd,
        recupera_costos,
        osp,
        pami,
        os_directo,
        otro,
        hpgd,
        menor_10k,
        created_at,
        updated_at
    )
SELECT
    ech.cuie,
    ech.siisa,
    ech.nombre,
    ech.domicilio,
    ech.codigo_postal,
    ech.denominacion_legal,
    etef.id_tipo_efector,
    SUBSTRING(ech.rural, 1, 1),
    SUBSTRING(ech.cics, 1, 1),
    etc.id_categorizacion,
    etda.id_dependencia_administrativa,
    ech.dependencia_sanitaria,
    CASE
        WHEN ech.compromiso_gestion IS NULL THEN 'N'
        ELSE ech.compromiso_gestion
    END as compromiso_gestion,
    1 AS id_estado,
    CASE
        WHEN ech.sistema_hcd IS NULL THEN 'N'
        ELSE 'S'
    END AS hcd,
    CASE
        WHEN ech.recupera_costos IS NULL THEN 'N'
        ElSE ech.recupera_costos
    END as recupera_costos,
    CASE
        WHEN ech.osp IS NULL THEN 'N'
        ElSE ech.osp
    END as osp,
    CASE
        WHEN ech.pami IS NULL THEN 'N'
        ElSE ech.pami
    END as pami,
    CASE
        WHEN ech.os_directo IS NULL THEN 'N'
        ElSE ech.os_directo
    END as os_directo,
    CASE
        WHEN ech.otro IS NULL THEN 'N'
        ElSE ech.otro
    END as otro,
    CASE
        WHEN ech.hpgd IS NULL THEN 'N'
        ElSE ech.hpgd
    END as hpgd,
    ech.menos_10mil_habitantes AS menor_10k,
    now() AS created_at,
    now() AS updated_at
FROM
    efectores.tmp_chaco_10_2020 ech
LEFT JOIN
    efectores.tipo_efector etef ON UPPER(ech.sigla_tipo_efector) = UPPER(etef.sigla)
LEFT JOIN
    efectores.tipo_categorizacion etc ON UPPER(ech.categorizacion) = UPPER(etc.descripcion)
LEFT JOIN
    efectores.tipo_dependencia_administrativa etda ON UPPER(ech.dependencia_administrativa) = UPPER(etda.descripcion)
ON CONFLICT (cuie) DO UPDATE
SET
    siisa = excluded.siisa,
    nombre = excluded.nombre,
    domicilio = excluded.domicilio,
    codigo_postal = excluded.codigo_postal,
    denominacion_legal = excluded.denominacion_legal,
    id_tipo_efector = excluded.id_tipo_efector,
    rural = SUBSTRING(excluded.rural, 1, 1),
    cics = SUBSTRING(excluded.cics, 1, 1),
    id_categorizacion = excluded.id_categorizacion,
    id_dependencia_administrativa = excluded.id_dependencia_administrativa,
    dependencia_sanitaria = excluded.dependencia_sanitaria,
    compromiso_gestion = 
    (
        CASE
            WHEN excluded.compromiso_gestion IS NULL THEN 'N'
            ELSE excluded.compromiso_gestion
        END
    ),
    id_estado = 1,
    hcd =
    (
        CASE 
            WHEN excluded.hcd IS NULL THEN 'N'
            ELSE 'S'
        END
    ),
    recupera_costos = 
    (
        CASE
            WHEN excluded.recupera_costos IS NULL THEN 'N'
            ELSE excluded.recupera_costos
        END
    ),
    osp = 
    (
        CASE
            WHEN excluded.osp IS NULL THEN 'N'
            ELSE excluded.osp
        END
    ),
    pami =
    (
        CASE
            WHEN excluded.pami IS NULL THEN 'N'
            ELSE excluded.pami
        END
    ),
    os_directo =
    (
        CASE
            WHEN excluded.os_directo IS NULL THEN 'N'
            ELSE excluded.os_directo
        END
    ),
    otro = 
    (
        CASE
            WHEN excluded.otro IS NULL THEN 'N'
            ELSE excluded.otro
        END
    ),
    hpgd = 
    (
        CASE
            WHEN excluded.hpgd IS NULL THEN 'N'
            ELSE excluded.hpgd
        END
    ),
    menor_10k = excluded.menor_10k,
    updated_at = now();


-- Update id_efector con los nuevos efectores en la tabla temporal para no hacer el join siempre por cuie
UPDATE
    efectores.tmp_chaco_10_2020 ech
SET
    id_efector = e.id_efector
FROM
    efectores.efectores e
WHERE
    e.cuie = ech.cuie;


-- Insert o Update de efectores.datos_efector
INSERT INTO
    efectores.datos_efector
    (
        id_efector,
        categoria_maternidad,
        cumple_cone,
        categoria_neonatologia,
        opera_malformaciones,
        categoria_cc,
        categoria_iam,
        red_flap
    )
SELECT
    ech.id_efector,
    ech.categoria_maternidad,
    ech.cumple_cone,
    ech.categoria_neonatologia,
    ech.opera_malformaciones,
    ech.categoria_cc,
    ech.categoria_iam,
    ech.red_flap
FROM
    efectores.tmp_chaco_10_2020 ech
WHERE
    ech.cumple_cone IS NOT NULL
ON CONFLICT (id_efector) DO UPDATE
SET
    categoria_maternidad = excluded.categoria_maternidad,
    cumple_cone = excluded.cumple_cone,
    categoria_neonatologia = excluded.categoria_neonatologia,
    opera_malformaciones = excluded.opera_malformaciones,
    categoria_cc = excluded.categoria_cc,
    categoria_iam = excluded.categoria_iam,
    red_flap = excluded.red_flap;


-- Insert o Update efectores.datos_geograficos
INSERT INTO
    efectores.datos_geograficos
    (
        id_efector,
        id_provincia,
        id_departamento,
        id_localidad,
        ciudad,
        latitud,
        longitud,
        created_at,
        updated_at
    )
SELECT
    ech.id_efector,
    ech.id_provincia,
    de.id as id_departamento,
    l.id as id_localidad,
    ech.ciudad,
    ech.latitud,
    ech.longitud,
    now() as created_at,
    now() as updated_at
FROM
    efectores.tmp_chaco_10_2020 ech
LEFT JOIN
    geo.departamentos de ON UPPER(ech.departamento) = UPPER(de.nombre_departamento) and ech.id_provincia = de.id_provincia
LEFT JOIN
    geo.localidades l ON UPPER(ech.localidad) = UPPER(l.nombre_localidad) and ech.id_provincia = l.id_provincia and de.id_departamento = l.id_departamento
WHERE
    ech.id_provincia IS NOT NULL
    AND
    de.id IS NOT NULL
    AND
    l.id IS NOT NULL
ON CONFLICT (id_efector) DO UPDATE
SET
    id_provincia = excluded.id_provincia,
    id_departamento = excluded.id_departamento,
    id_localidad = excluded.id_localidad,
    ciudad = excluded.ciudad,
    latitud = excluded.latitud,
    longitud = excluded.longitud,
    updated_at = now();


-- Insert o Update efectores.descentralizacion
INSERT INTO
efectores.descentralizacion 
    (
        id_efector,
        internet,
        factura_descentralizada,
        factura_on_line
    )
SELECT
    ech.id_efector,
    ech.internet,
    ech.factura_descentralizada,
    ech.factura_online AS factura_on_line
FROM
    efectores.tmp_chaco_10_2020 ech
WHERE
    ech.internet IS NOT NULL
ON CONFLICT (id_efector) DO UPDATE
SET
    internet = excluded.internet,
    factura_descentralizada = excluded.factura_descentralizada,
    factura_on_line = excluded.factura_on_line;


-- Insert o Update efectores.compromiso_gestion
INSERT INTO
efectores.compromiso_gestion
    (
        id_efector,
        numero_compromiso,
        firmante,
        fecha_suscripcion,
        fecha_inicio,
        fecha_fin,
        pago_indirecto,
        created_at,
        updated_at
    )
SELECT
    ech.id_efector,
    ech.numero_compromiso,
    ech.firmante_compromiso AS firmante,
    CAST(ech.fecha_suscripcion_compromiso AS DATE) AS fecha_suscripcion,
    CAST(ech.fecha_inicio_compromiso AS DATE) AS fecha_inicio,
    CAST(ech.fecha_fin_compromiso AS DATE) AS fecha_fin,
    ech.pago_indirecto,
    now() AS created_at,
    now() AS updated_at
FROM
    efectores.tmp_chaco_10_2020 ech
WHERE
    ech.numero_compromiso IS NOT NULL
ON CONFLICT (id_efector) DO UPDATE
SET
    numero_compromiso = excluded.numero_compromiso,
    firmante = excluded.firmante,
    fecha_suscripcion = excluded.fecha_suscripcion,
    fecha_inicio = excluded.fecha_inicio,
    fecha_fin = excluded.fecha_fin,
    pago_indirecto = excluded.pago_indirecto,
    updated_at = now();


-- Insert o Update efectores.convenio_administrativo
INSERT INTO efectores.convenio_administrativo
    (
        id_efector,
        numero_compromiso,
        firmante,
        nombre_tercer_administrador,
        codigo_tercer_administrador,
        fecha_suscripcion,
        fecha_inicio,
        fecha_fin,
        created_at,
        updated_at
    )
SELECT
    ech.id_efector,
    ech.numero_convenio AS numero_compromiso,
    ech.firmante_convenio AS firmante,
    ech.nombre_tercer_administrador,
    ech.codigo_tercer_administrador,
    CAST(ech.fecha_suscripcion_convenio AS DATE) AS fecha_suscripcion,
    CAST(ech.fecha_inicio_convenio AS DATE) AS fecha_inicio,
    CAST(ech.fecha_fin_convenio AS DATE) fecha_fin,
    now() AS created_at,
    now() AS updated_at
FROM
    efectores.tmp_chaco_10_2020 ech
WHERE
    ech.numero_convenio IS NOT NULL
ON CONFLICT (id_efector) DO UPDATE
SET
    numero_compromiso = excluded.numero_compromiso,
    firmante = excluded.firmante,
    nombre_tercer_administrador = excluded.nombre_tercer_administrador, 
    codigo_tercer_administrador = excluded.codigo_tercer_administrador,
    fecha_suscripcion = excluded.fecha_suscripcion,
    fecha_inicio = excluded.fecha_inicio,
    fecha_fin = excluded.fecha_fin,
    updated_at = now();


-- INSERTS PARA RELACIONES UNO A MUCHOS
-- Insert de Emails
INSERT INTO
efectores.email
    (
        id_efector,
        email
    )
SELECT
    ech.id_efector,
    ech.email
FROM
    efectores.tmp_chaco_10_2020 ech
LEFT JOIN
    efectores.efectores e ON ech.cuie = e.cuie
WHERE
    ech.email IS NOT NULL
ON CONFLICT ON CONSTRAINT efectores_email_id_efector_email_unique DO NOTHING;


-- Insert de Telefonos
INSERT INTO
    efectores.telefonos
    (
        id_efector,
        numero_telefono
    )
SELECT
    ech.id_efector,
    ech.telefono AS numero_telefono
FROM
    efectores.tmp_chaco_10_2020 ech
LEFT JOIN
    efectores.efectores e ON ech.cuie = e.cuie
WHERE
    ech.telefono IS NOT NULL
ON CONFLICT ON CONSTRAINT efectores_telefonos_id_efector_numero_telefono_unique DO NOTHING;

COMMIT;
