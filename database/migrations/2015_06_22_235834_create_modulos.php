<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.modulos', function (Blueprint $table) {
			$table->increments('id_modulo');
			$table->integer('id_padre');
			$table->char('arbol', 1)->nullable();
			$table->integer('nivel_1');
			$table->integer('nivel_2')->nullable();
			$table->string('descripcion', 100);
			$table->string('modulo', 100)->nullable();
			$table->string('icono' , 100)->nullable();
			$table->nullableTimestamps();

			$table->unique(['nivel_1', 'nivel_2']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.modulos');
	}
}
