<?php

use Illuminate\Database\Seeder;

class EfectoresConvenioAdministrativo extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.convenio_administrativo(id_efector,numero_compromiso,firmante,nombre_tercer_administrador,codigo_tercer_administrador,fecha_suscripcion,fecha_inicio,fecha_fin,created_at,updated_at)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_efector,numero_compromiso,firmante,nombre_tercer_administrador,codigo_tercer_administrador,fecha_suscripcion,fecha_inicio,fecha_fin,now() as created_at, now() as updated_at
		    FROM efectores.convenio_administrativo')
	    AS migracion(id_efector integer,
  numero_compromiso character varying(50),
  firmante character varying(200),
  nombre_tercer_administrador character varying(200),
  codigo_tercer_administrador character varying(50),
  fecha_suscripcion date,
  fecha_inicio date,
  fecha_fin date,
  created_at timestamp(0) without time zone,
  updated_at timestamp(0) without time zone)
);");
	}
}
