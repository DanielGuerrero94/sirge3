<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasGeoLocalidades extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('geo.localidades', function (Blueprint $table) {
			$table->string('id_provincia', 2);
			$table->string('id_departamento', 3);
			$table->string('id_localidad', 3);
			$table->primary(['id_provincia', 'id_departamento', 'id_localidad']);
			$table->string('nombre_localidad', 200)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('geo.localidades');
	}
}
