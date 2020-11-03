select
    e.cuie,
    e.siisa,
    e.nombre,
    e.domicilio,
    e.codigo_postal,
    e.denominacion_legal,
    tef.sigla as siga_tipo_efector,
    tef.descripcion as tipo_efector,
    e.rural,
    e.cics,
    tca.sigla as sigla_categorizacion,
    tca.descripcion as categorizacion,
    tda.descripcion as dependencia_administrativa,
    e.dependencia_sanitaria,
    e.compromiso_gestion,
    e.id_sistema_hcd as sistema_hcd,
    e.recupera_costos,
    e.osp,
    e.pami,
    e.os_directo,
    e.otro,
    e.hpgd,
    de.categoria_maternidad,
    de.cumple_cone,
    de.categoria_neonatologia,
    de.opera_malformaciones,
    de.categoria_cc,
    de.categoria_iam,
    de.red_flap,
    dg.id_provincia,
    pro.descripcion as nombre_provincia,
    dep.nombre_departamento as departamento,
    lo.nombre_localidad as localidad,
    dg.ciudad,
    e.menor_10k as menos_10mil_habitantes,
    dg.latitud,
    dg.longitud,
    des.internet,
    des.factura_descentralizada,
    des.factura_on_line,
    cg.numero_compromiso,
    cg.firmante as firmante_compromiso,
    cg.fecha_suscripcion as fecha_suscripcion_compromiso,
    cg.fecha_inicio as fecha_inicio_compromiso,
    cg.fecha_fin as fecha_fin_compromiso,
    cg.pago_indirecto,
    ca.numero_compromiso as numero_convenio,
    ca.firmante as firmante_convenio,
    ca.nombre_tercer_administrador,
    ca.codigo_tercer_administrador,
    ca.fecha_suscripcion as fecha_suscripcion_convenio,
    ca.fecha_inicio as fecha_inicio_convenio,
    ca.fecha_fin as fecha_fin_convenio,
    em.email,
    t.numero_telefono
from
    efectores.efectores e
left join
    efectores.datos_efector de
        on de.id_efector = e.id_efector
left join
    efectores.datos_geograficos dg
        on dg.id_efector = e.id_efector
left join
    efectores.descentralizacion des
        on des.id_efector = e.id_efector
left join
    efectores.compromiso_gestion cg
        on cg.id_efector = e.id_efector
left join
    efectores.convenio_administrativo ca
        on ca.id_efector = e.id_efector
left join
    efectores.email em
        on em.id_efector = e.id_efector
left join
    efectores.telefonos t
        on t.id_efector = e.id_efector
left join
    efectores.tipo_efector tef
        on tef.id_tipo_efector = e.id_tipo_efector
left join
    efectores.tipo_categorizacion tca
        on tca.id_categorizacion = e.id_categorizacion
left join
    efectores.tipo_dependencia_administrativa tda
        on tda.id_dependencia_administrativa = e.id_dependencia_administrativa
left join
    geo.provincias pro
        on pro.id_provincia = dg.id_provincia
left join
    geo.departamentos dep
        on dep.id = dg.id_departamento
left join
    geo.localidades lo
        on lo.id = dg.id_localidad
where
    e.id_efector
    in  
    (
        select
            id_efector
        from
            efectores.tmp_chaco_10_2020
    )
order by
    e.cuie;
