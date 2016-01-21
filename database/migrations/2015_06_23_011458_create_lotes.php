<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLotes extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.lotes', function (Blueprint $table) {
			$table->increments('lote');
			$table->integer('id_subida')->nullable();
			$table->integer('id_usuario');
			$table->string('id_provincia', 2);
			$table->integer('id_estado');
			$table->integer('registros_in');
			$table->integer('registros_out');
			$table->integer('registros_mod')->default(0);
			$table->timestamp('inicio')->default(DB::raw('now()::timestamp(0)'));
			$table->timestamp('fin')->nullable();
			$table->nullableTimestamps();

			$table->foreign('id_subida')->references('id_subida')->on('sistema.subidas');
			$table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
			$table->foreign('id_provincia')->references('id_provincia')->on('geo.provincias');
			$table->foreign('id_estado')->references('id_estado')->on('sistema.estados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.lotes');
	}
}
