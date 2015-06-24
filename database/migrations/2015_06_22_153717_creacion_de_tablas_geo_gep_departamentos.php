<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasGeoGepDepartamentos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('geo.gep_departamentos', function (Blueprint $table) {
			$table->integer('id_punto')->unsigned();
			$table->string('id_provincia', 2);
			$table->string('id_departamento', 3);
			$table->float('latitud');
			$table->float('longitud');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('geo.gep_departamentos');
	}
}
