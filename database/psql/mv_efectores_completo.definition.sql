                                      Materialized view "efectores.mv_efectores_completo"
            Column            |          Type          | Collation | Nullable | Default | Storage  | Stats target | Description 
------------------------------+------------------------+-----------+----------+---------+----------+--------------+-------------
 cuie                         | character(6)           |           |          |         | extended |              | 
 siisa                        | character(14)          |           |          |         | extended |              | 
 nombre_efector               | character varying(200) |           |          |         | extended |              | 
 domicilio                    | character varying(500) |           |          |         | extended |              | 
 codigo_postal                | character varying(8)   |           |          |         | extended |              | 
 denominacion_legal           | character varying(200) |           |          |         | extended |              | 
 id_tipo_efector              | integer                |           |          |         | plain    |              | 
 sigla_tipo                   | character(3)           |           |          |         | extended |              | 
 tipo_efector                 | character varying(50)  |           |          |         | extended |              | 
 rural                        | character(1)           |           |          |         | extended |              | 
 cics                         | character varying(1)   |           |          |         | extended |              | 
 id_categorizacion            | integer                |           |          |         | plain    |              | 
 sigla_categorizacion         | character(6)           |           |          |         | extended |              | 
 categorizacion               | character varying(100) |           |          |         | extended |              | 
 dependencia_sanitaria        | character varying(200) |           |          |         | extended |              | 
 compromiso_gestion           | character(1)           |           |          |         | extended |              | 
 hcd                          | character(1)           |           |          |         | extended |              | 
 nombre_hce                   | character varying(50)  |           |          |         | extended |              | 
 id_provincia                 | character(2)           |           |          |         | extended |              | 
 nombre_provincia             | character varying(100) |           |          |         | extended |              | 
 indec_departamento           | character(3)           |           |          |         | extended |              | 
 departamento                 | character varying(200) |           |          |         | extended |              | 
 indec_localidad              | character varying(5)   |           |          |         | extended |              | 
 localidad                    | character varying(200) |           |          |         | extended |              | 
 ciudad                       | character varying(200) |           |          |         | extended |              | 
 latitud                      | double precision       |           |          |         | plain    |              | 
 longitud                     | double precision       |           |          |         | plain    |              | 
 internet                     | character(1)           |           |          |         | extended |              | 
 factura_descentralizada      | character(1)           |           |          |         | extended |              | 
 factura_online               | character(1)           |           |          |         | extended |              | 
 numero_compromiso            | character varying(50)  |           |          |         | extended |              | 
 firmante_compromiso          | character varying(200) |           |          |         | extended |              | 
 fecha_suscripcion_compromiso | date                   |           |          |         | plain    |              | 
 fecha_inicio_compromiso      | date                   |           |          |         | plain    |              | 
 fecha_fin_compromiso         | date                   |           |          |         | plain    |              | 
 pago_indirecto               | character varying(1)   |           |          |         | extended |              | 
 numero_convenio              | character varying(50)  |           |          |         | extended |              | 
 firmante_convenio            | character varying(200) |           |          |         | extended |              | 
 nombre_tercer_administrador  | character varying(200) |           |          |         | extended |              | 
 codigo_tercer_administrador  | character varying(50)  |           |          |         | extended |              | 
 fecha_suscripcion_convenio   | date                   |           |          |         | plain    |              | 
 fecha_inicio_convenio        | date                   |           |          |         | plain    |              | 
 fecha_fin_convenio           | date                   |           |          |         | plain    |              | 
 email                        | character varying(200) |           |          |         | extended |              | 
 telefono                     | character varying(200) |           |          |         | extended |              | 
View definition:
 SELECT v_efectores_completo.cuie,
    v_efectores_completo.siisa,
    v_efectores_completo.nombre AS nombre_efector,
    v_efectores_completo.domicilio,
    v_efectores_completo.codigo_postal,
    v_efectores_completo.denominacion_legal,
    v_efectores_completo.id_tipo_efector,
    v_efectores_completo.sigla AS sigla_tipo,
    v_efectores_completo.tipo_efector_descripcion AS tipo_efector,
    v_efectores_completo.rural,
    v_efectores_completo.cics,
    v_efectores_completo.id_categorizacion,
    v_efectores_completo.cat_sigla AS sigla_categorizacion,
    v_efectores_completo.tipo_cat_descripcion AS categorizacion,
    v_efectores_completo.dependencia_sanitaria,
    v_efectores_completo.compromiso_gestion,
    v_efectores_completo.hcd,
    v_efectores_completo.sistema_hcd AS nombre_hce,
    v_efectores_completo.id_provincia,
    v_efectores_completo.nombre_provincia,
    v_efectores_completo.indec_departamento,
    v_efectores_completo.nombre_departamento AS departamento,
    v_efectores_completo.indec_localidad,
    v_efectores_completo.nombre_localidad AS localidad,
    v_efectores_completo.ciudad,
    v_efectores_completo.latitud,
    v_efectores_completo.longitud,
    v_efectores_completo.internet,
    v_efectores_completo.factura_descentralizada,
    v_efectores_completo.factura_on_line AS factura_online,
    v_efectores_completo.numero_compromiso,
    v_efectores_completo.firmante AS firmante_compromiso,
    v_efectores_completo.fecha_suscripcion AS fecha_suscripcion_compromiso,
    v_efectores_completo.fecha_inicio AS fecha_inicio_compromiso,
    v_efectores_completo.fecha_fin AS fecha_fin_compromiso,
    v_efectores_completo.pago_indirecto,
    v_efectores_completo.numero_convenio,
    v_efectores_completo.convenio_firmante AS firmante_convenio,
    v_efectores_completo.nombre_tercer_administrador,
    v_efectores_completo.codigo_tercer_administrador,
    v_efectores_completo.convenio_fecha_suscripcion AS fecha_suscripcion_convenio,
    v_efectores_completo.convenio_fecha_inicio AS fecha_inicio_convenio,
    v_efectores_completo.convenio_fecha_fin AS fecha_fin_convenio,
    v_efectores_completo.email,
    v_efectores_completo.telefono
   FROM efectores.v_efectores_completo;

