<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComentarios extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.comentarios', function (Blueprint $table) {
			$table->increments('id_comentario');
			$table->integer('id_usuario');
			$table->text('comentario');
			$table->timestamp('fecha_comentario')->default(DB::raw('now()::timestamp(0)'));

			$table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.comentarios');
	}
}
