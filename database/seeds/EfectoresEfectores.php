<?php

use Illuminate\Database\Seeder;

class EfectoresEfectores extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.efectores(id_efector,cuie,siisa,nombre,domicilio,codigo_postal,denominacion_legal,id_tipo_efector,rural,cics,id_categorizacion,id_dependencia_administrativa,dependencia_sanitaria,integrante,compromiso_gestion,priorizado,ppac,id_estado)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_efector,cuie,siisa,nombre,domicilio,codigo_postal,denominacion_legal,id_tipo_efector,rural,cics,id_categorizacion,id_dependencia_administrativa,dependencia_sanitaria,integrante,compromiso_gestion,priorizado,coalesce(ppac,''N''),id_estado
		    FROM efectores.efectores')
	    AS migracion(id_efector integer,
  cuie character(6),
  siisa character(14),
  nombre character varying(200),
  domicilio character varying(500),
  codigo_postal character varying(8),
  denominacion_legal character varying(200),
  id_tipo_efector integer,
  rural character(1),
  cics character(1),
  id_categorizacion integer,
  id_dependencia_administrativa integer,
  dependencia_sanitaria character varying(200),
  integrante character(1),
  compromiso_gestion character(1),
  priorizado character(1),
  ppac character(1),
  id_estado integer)
);");
	}
}
