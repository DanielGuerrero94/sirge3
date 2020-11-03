--EFECTORES CON SISAS REPETIDOS

select
    e.cuie,
    e.siisa,
    p.descripcion as provincia,
    e.domicilio,
    es.descripcion,
    e.compromiso_gestion,
    cg.numero_compromiso,
    cg.fecha_suscripcion,
    cg.fecha_inicio,
    cg.fecha_fin,
    cg.pago_indirecto
from efectores.efectores e
left join efectores.datos_geograficos dg
    on e.id_efector = dg.id_efector
left join geo.provincias p
    on p.id_provincia = dg.id_provincia
left join efectores.tipo_estado es
    on e.id_estado = es.id_estado
left join efectores.compromiso_gestion cg
    on e.id_efector = cg.id_efector
where e.siisa in (
    select
        siisa
    from (
        select
            siisa,
            count(*) as cantidad_repetidos
        from efectores.efectores
        group by siisa) as cant_rep
        where cantidad_repetidos > 1
    )
)
and siisa != '99999999999999'
and siisa != '              '
and siisa != '00000000000000'
order by e.siisa;