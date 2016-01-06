<?php

use Illuminate\Database\Seeder;

class EfectoresCompromisoGestion extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.compromiso_gestion(id_efector,numero_compromiso,firmante,fecha_suscripcion,fecha_inicio,fecha_fin,pago_indirecto,created_at,updated_at)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_efector,numero_compromiso,firmante,fecha_suscripcion,fecha_inicio,fecha_fin,coalesce(pago_indirecto,''N''), now() as created_at, now() as updated_at
		    FROM efectores.compromiso_gestion')
	    AS migracion(id_efector integer,
  numero_compromiso character varying(50),
  firmante character varying(200),
  fecha_suscripcion date,
  fecha_inicio date,
  fecha_fin date,
  pago_indirecto character(1),
  created_at timestamp(0) without time zone,
  updated_at timestamp(0) without time zone)
);");
	}
}
