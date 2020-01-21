                                          View "efectores.v_efectores_completo"
            Column             |              Type              | Collation | Nullable | Default | Storage  | Description 
-------------------------------+--------------------------------+-----------+----------+---------+----------+-------------
 id_efector                    | integer                        |           |          |         | plain    | 
 cuie                          | character(6)                   |           |          |         | extended | 
 siisa                         | character(14)                  |           |          |         | extended | 
 nombre                        | character varying(200)         |           |          |         | extended | 
 domicilio                     | character varying(500)         |           |          |         | extended | 
 codigo_postal                 | character varying(8)           |           |          |         | extended | 
 denominacion_legal            | character varying(200)         |           |          |         | extended | 
 id_tipo_efector               | integer                        |           |          |         | plain    | 
 rural                         | character(1)                   |           |          |         | extended | 
 cics                          | character varying(1)           |           |          |         | extended | 
 id_categorizacion             | integer                        |           |          |         | plain    | 
 id_dependencia_administrativa | integer                        |           |          |         | plain    | 
 dependencia_sanitaria         | character varying(200)         |           |          |         | extended | 
 integrante                    | character(1)                   |           |          |         | extended | 
 compromiso_gestion            | character(1)                   |           |          |         | extended | 
 priorizado                    | character(1)                   |           |          |         | extended | 
 ppac                          | character(1)                   |           |          |         | extended | 
 id_estado                     | integer                        |           |          |         | plain    | 
 created_at                    | timestamp(0) without time zone |           |          |         | plain    | 
 updated_at                    | timestamp(0) without time zone |           |          |         | plain    | 
 hcd                           | character(1)                   |           |          |         | extended | 
 id_sistema_hcd                | smallint                       |           |          |         | plain    | 
 sistema_hcd                   | character varying(50)          |           |          |         | extended | 
 dg_id_efector                 | integer                        |           |          |         | plain    | 
 id_provincia                  | character(2)                   |           |          |         | extended | 
 nombre_provincia              | character varying(100)         |           |          |         | extended | 
 id_departamento               | smallint                       |           |          |         | plain    | 
 id_localidad                  | smallint                       |           |          |         | plain    | 
 ciudad                        | character varying(200)         |           |          |         | extended | 
 latitud                       | double precision               |           |          |         | plain    | 
 longitud                      | double precision               |           |          |         | plain    | 
 indec_departamento            | character(3)                   |           |          |         | extended | 
 nombre_departamento           | character varying(200)         |           |          |         | extended | 
 loc_indec_departamento        | character(3)                   |           |          |         | extended | 
 indec_localidad               | character varying(5)           |           |          |         | extended | 
 nombre_localidad              | character varying(200)         |           |          |         | extended | 
 desc_id_efector               | integer                        |           |          |         | plain    | 
 internet                      | character(1)                   |           |          |         | extended | 
 factura_descentralizada       | character(1)                   |           |          |         | extended | 
 factura_on_line               | character(1)                   |           |          |         | extended | 
 id_compromiso                 | integer                        |           |          |         | plain    | 
 comp_id_efector               | integer                        |           |          |         | plain    | 
 numero_compromiso             | character varying(50)          |           |          |         | extended | 
 firmante                      | character varying(200)         |           |          |         | extended | 
 fecha_suscripcion             | date                           |           |          |         | plain    | 
 fecha_inicio                  | date                           |           |          |         | plain    | 
 fecha_fin                     | date                           |           |          |         | plain    | 
 pago_indirecto                | character varying(1)           |           |          |         | extended | 
 id_convenio                   | integer                        |           |          |         | plain    | 
 conv_id_efector               | integer                        |           |          |         | plain    | 
 numero_convenio               | character varying(50)          |           |          |         | extended | 
 convenio_firmante             | character varying(200)         |           |          |         | extended | 
 nombre_tercer_administrador   | character varying(200)         |           |          |         | extended | 
 codigo_tercer_administrador   | character varying(50)          |           |          |         | extended | 
 convenio_fecha_suscripcion    | date                           |           |          |         | plain    | 
 convenio_fecha_inicio         | date                           |           |          |         | plain    | 
 convenio_fecha_fin            | date                           |           |          |         | plain    | 
 neo_siisa                     | character(14)                  |           |          |         | extended | 
 id_categoria                  | integer                        |           |          |         | plain    | 
 neo_id                        | integer                        |           |          |         | plain    | 
 obs_siisa                     | character(14)                  |           |          |         | extended | 
 obs_id_categoria              | integer                        |           |          |         | plain    | 
 obs_id                        | integer                        |           |          |         | plain    | 
 ppac_id_efector               | integer                        |           |          |         | plain    | 
 addenda_perinatal             | character(1)                   |           |          |         | extended | 
 fecha_addenda_perinatal       | date                           |           |          |         | plain    | 
 perinatal_ac                  | character(1)                   |           |          |         | extended | 
 add_id                        | integer                        |           |          |         | plain    | 
 add_id_efector                | integer                        |           |          |         | plain    | 
 id_addenda                    | integer                        |           |          |         | plain    | 
 fecha_addenda                 | date                           |           |          |         | plain    | 
 tipo_id_tipo_efector          | integer                        |           |          |         | plain    | 
 sigla                         | character(3)                   |           |          |         | extended | 
 tipo_efector_descripcion      | character varying(50)          |           |          |         | extended | 
 tipo_cat_id_categorizacion    | integer                        |           |          |         | plain    | 
 cat_sigla                     | character(6)                   |           |          |         | extended | 
 tipo_cat_descripcion          | character varying(100)         |           |          |         | extended | 
 prio_fecha                    | date                           |           |          |         | plain    | 
 email                         | character varying(200)         |           |          |         | extended | 
 telefono                      | character varying(200)         |           |          |         | extended | 
View definition:
 SELECT e.id_efector,
    e.cuie,
    e.siisa,
    e.nombre,
    e.domicilio,
    e.codigo_postal,
    e.denominacion_legal,
    e.id_tipo_efector,
    e.rural,
    e.cics,
    e.id_categorizacion,
    e.id_dependencia_administrativa,
    e.dependencia_sanitaria,
    e.integrante,
    e.compromiso_gestion,
    e.priorizado,
    e.ppac,
    e.id_estado,
    e.created_at,
    e.updated_at,
    e.hcd,
    e.id_sistema_hcd,
    hcd.nombre AS sistema_hcd,
    dg.id_efector AS dg_id_efector,
    dg.id_provincia,
    prov.descripcion AS nombre_provincia,
    dg.id_departamento,
    dg.id_localidad,
    dg.ciudad,
    dg.latitud,
    dg.longitud,
    dep.id_departamento AS indec_departamento,
    dep.nombre_departamento,
    loc.id_departamento AS loc_indec_departamento,
    loc.id_localidad AS indec_localidad,
    loc.nombre_localidad,
    des.id_efector AS desc_id_efector,
    des.internet,
    des.factura_descentralizada,
    des.factura_on_line,
    comp.id_compromiso,
    comp.id_efector AS comp_id_efector,
    comp.numero_compromiso,
    comp.firmante,
    comp.fecha_suscripcion,
    comp.fecha_inicio,
    comp.fecha_fin,
    comp.pago_indirecto,
    conv.id_convenio,
    conv.id_efector AS conv_id_efector,
    conv.numero_compromiso AS numero_convenio,
    conv.firmante AS convenio_firmante,
    conv.nombre_tercer_administrador,
    conv.codigo_tercer_administrador,
    conv.fecha_suscripcion AS convenio_fecha_suscripcion,
    conv.fecha_inicio AS convenio_fecha_inicio,
    conv.fecha_fin AS convenio_fecha_fin,
    neo.siisa AS neo_siisa,
    neo.id_categoria,
    neo.id AS neo_id,
    obs.siisa AS obs_siisa,
    obs.id_categoria AS obs_id_categoria,
    obs.id AS obs_id,
    ppac.id_efector AS ppac_id_efector,
    ppac.addenda_perinatal,
    ppac.fecha_addenda_perinatal,
    ppac.perinatal_ac,
    add.id AS add_id,
    add.id_efector AS add_id_efector,
    add.id_addenda,
    add.fecha_addenda,
    tipo.id_tipo_efector AS tipo_id_tipo_efector,
    tipo.sigla,
    tipo.descripcion AS tipo_efector_descripcion,
    cat.id_categorizacion AS tipo_cat_id_categorizacion,
    cat.sigla AS cat_sigla,
    cat.descripcion AS tipo_cat_descripcion,
    ( SELECT max(p.fecha) AS prio_fecha
           FROM efectores.priorizados p
          WHERE p.cuie = e.cuie) AS prio_fecha,
    ( SELECT em.email
           FROM efectores.email em
          WHERE em.id_efector = e.id_efector
         LIMIT 1) AS email,
    ( SELECT tele.numero_telefono AS telefono
           FROM efectores.telefonos tele
          WHERE tele.id_efector = e.id_efector
         LIMIT 1) AS telefono
   FROM efectores.efectores e
     LEFT JOIN efectores.datos_geograficos dg ON e.id_efector = dg.id_efector
     LEFT JOIN geo.departamentos dep ON dep.id = dg.id_departamento
     LEFT JOIN geo.localidades loc ON loc.id = dg.id_localidad
     LEFT JOIN efectores.descentralizacion des ON e.id_efector = des.id_efector
     LEFT JOIN efectores.compromiso_gestion comp ON e.id_efector = comp.id_efector
     LEFT JOIN efectores.convenio_administrativo conv ON e.id_efector = conv.id_efector
     LEFT JOIN efectores.efectores_neonatales neo ON e.siisa = neo.siisa
     LEFT JOIN efectores.efectores_obstetricos obs ON e.siisa = obs.siisa
     LEFT JOIN efectores.efectores_ppac ppac ON e.id_efector = ppac.id_efector
     LEFT JOIN efectores.efectores_addendas add ON e.id_efector = add.id_efector
     LEFT JOIN efectores.tipo_efector tipo ON e.id_tipo_efector = tipo.id_tipo_efector
     LEFT JOIN efectores.tipo_categorizacion cat ON e.id_categorizacion = cat.id_categorizacion
     LEFT JOIN geo.provincias prov ON dg.id_provincia = prov.id_provincia
     LEFT JOIN hcd.sistemas hcd ON e.id_sistema_hcd = hcd.id_sistema
  WHERE e.id_estado = 1;

