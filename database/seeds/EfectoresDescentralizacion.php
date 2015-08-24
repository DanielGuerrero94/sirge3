<?php

use Illuminate\Database\Seeder;

class EfectoresDescentralizacion extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.descentralizacion(id_efector,internet,factura_descentralizada,factura_on_line)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_efector,coalesce(internet,''N''),coalesce(factura_descentralizada,''N''),coalesce(factura_on_line,''N'')
		    FROM efectores.descentralizacion')
	    AS migracion(id_efector integer,
  internet character(1),
  factura_descentralizada character(1),
  factura_on_line character(1))
);");
	}
}
