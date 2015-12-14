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
			$table->increments('id');
			$table->char('id_provincia', 2);
			$table->char('id_departamento', 3);
			$table->char('id_localidad', 3);
			$table->string('nombre_localidad', 200);
			$table->string('id', 4);

			$table->unique(['id_provincia', 'id_departamento', 'id_localidad']);
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
