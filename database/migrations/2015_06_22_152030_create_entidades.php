<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEntidades extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.provincias', function (Blueprint $table) {
			$table->char('id_provincia', 2)->primary();
			$table->integer('id_tipo_entidad');
			$table->integer('id_region');
			$table->string('descripcion', 100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.provincias');
	}
}
