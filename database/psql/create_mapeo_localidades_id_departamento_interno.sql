--MAPEO LOCALIDADES CON DEPARTAMENTO LOCALIDADES

select
    l.id as localidad_id,
    d.id as departamento_id,
    l.id_localidad as codigo_indec,
    l.nombre_localidad as nombre
from geo.localidades l
join geo.departamentos d
    on l.id_departamento = d.id_departamento
    and l.id_provincia = d.id_provincia;