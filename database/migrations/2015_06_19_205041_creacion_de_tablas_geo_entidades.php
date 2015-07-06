<?php

use Illuminate\Database\Migrations\Migration;

class CreacionDeTablasGeoEntidades extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement('CREATE TABLE geo.entidades
        (
          id_provincia character(2) NOT NULL,
          id_departamento character(3) NOT NULL,
          id_localidad character(3) NOT NULL,
          id_entidad character varying(2) NOT NULL,
          nombre_entidad character varying(200),
          CONSTRAINT entidades_pkey PRIMARY KEY (id_provincia, id_departamento, id_localidad, id_entidad)
        )');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('geo.entidades');
	}
}
