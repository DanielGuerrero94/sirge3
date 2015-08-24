<?php

use Illuminate\Database\Seeder;

class EfectoresEfectoresPpac extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		\DB::statement(" INSERT INTO efectores.efectores_ppac(id_efector,
  addenda_perinatal,
  fecha_addenda_perinatal,
  perinatal_ac,
  categoria_obstetrico,
  categoria_neonatal)
(
	SELECT *
	FROM dblink('dbname=sirge host=192.6.0.118 user=postgres password=PN2012\$',
	    'SELECT id_efector,
  addenda_perinatal,
  fecha_addenda_perinatal,
  perinatal_ac,
  categoria_obstetrico,
  categoria_neonatal
		    FROM efectores.efectores_ppac')
	    AS migracion(id_efector integer,
  addenda_perinatal character(1),
  fecha_addenda_perinatal date,
  perinatal_ac character(1),
  categoria_obstetrico character(1),
  categoria_neonatal character(1))
);");
	}
}
