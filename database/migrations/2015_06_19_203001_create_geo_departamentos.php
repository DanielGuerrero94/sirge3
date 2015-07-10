<?php

use Illuminate\Database\Migrations\Migration;

class CreacionDeTablasGeoV1 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('geo.departamentos' , function (Blueprint $table) {
			$table->increments('id');
			$table->char('id_provincia' , 2);
			$table->char('id_departamento' , 3);
			$table->string('nombre_departamento' , 200);

			$table->unique(['id_provincia', 'id_departamento']);
			$table->index(['id_provincia', 'id_departamento']);
		});
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
