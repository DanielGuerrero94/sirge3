create or replace view efectores.v_efectores_completo as (
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
  WHERE e.id_estado = 1);
