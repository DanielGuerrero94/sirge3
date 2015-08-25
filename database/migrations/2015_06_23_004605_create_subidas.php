<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubidas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.subidas', function (Blueprint $table) {
			$table->increments('id_subida');
			$table->integer('id_usuario');
			$table->timestamp('fecha_subida')->default(DB::raw('now()::timestamp(0)'));
			$table->integer('id_padron');
			$table->text('nombre_original');
			$table->text('nombre_actual');
			$table->float('size');
			$table->integer('id_estado')->default(0);

			$table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
			$table->foreign('id_padron')->references('id_padron')->on('sistema.padrones');
			$table->foreign('id_estado')->references('id_estado')->on('sistema.estados');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.subidas');
	}
}
