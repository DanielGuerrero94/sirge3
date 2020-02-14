CREATE TABLE efectores.datos_efector (
    id_datos_efector integer DEFAULT nextval('efectores.datos_efector_id_datos_efector_seq'::regclass) NOT NULL,
    id_efector integer NOT NULL,
    categoria_maternidad character(4),
    cumple_cone character(1) DEFAULT 'N'::character NOT NULL,
    categoria_neonatologia character(4),
    opera_malformaciones character(1) DEFAULT 'N'::character NOT NULL,
    categoria_cc character varying(20),
    categoria_iam character(3),
    red_flap character(1) DEFAULT 'N'::character NOT NULL
    );

ALTER TABLE efectores.datos_efector OWNER TO postgres;

ALTER TABLE ONLY efectores.datos_efector
    ADD CONSTRAINT datos_efector_pkey PRIMARY KEY (id_datos_efector);

-- ALTER TABLE ONLY efectores.datos_efector
-- ADD COLUMNS AFTER IMPORT
-- id_efector integer NOT NULL,
-- created_at timestamp(0) without time zone,
-- updated_at timestamp(0) without time zone

-- ALTER TABLE ONLY efectores.datos_efector
-- ADD CONSTRAINT efectores_datos_efector_id_datos_efector_foreign FOREIGN KEY (id_efector) REFERENCES efectores.efectores(id_efector) ON DELETE CASCADE;
