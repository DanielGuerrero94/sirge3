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
			$table->integer('id_punto')->primary();
			$table->char('id_provincia', 2);
			$table->char('id_departamento', 3);
			$table->float('latitud');
			$table->float('longitud');

			$table->unique(['id_punto','id_provincia','id_departamento']);
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
