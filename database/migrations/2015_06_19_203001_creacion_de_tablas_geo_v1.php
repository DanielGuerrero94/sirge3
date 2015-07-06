<?php

use Illuminate\Database\Migrations\Migration;

class CreacionDeTablasGeoV1 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement('CREATE TABLE geo.departamentos
        (
          id_provincia character(2) NOT NULL,
          id_departamento character(3) NOT NULL,
          nombre_departamento character varying(200),
          /*latitud numeric,
          longitud numeric,*/
          CONSTRAINT departamentos_pkey PRIMARY KEY (id_provincia, id_departamento)
        )');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('geo.departamentos');
	}
}
