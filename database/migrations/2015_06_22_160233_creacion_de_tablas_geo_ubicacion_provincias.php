<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasGeoUbicacionProvincias extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('geo.ubicacion_provincias', function (Blueprint $table) {
			$table->string('id_provincia', 2)->primary();
			$table->string('ll', 100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('geo.ubicacion_provincias');
	}
}
