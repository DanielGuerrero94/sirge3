<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableLogAcciones extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tablero.log_acciones', function (Blueprint $table) {
				$table->increments('id');
				$table->char('id_provincia', 2);
				$table->integer('id_usuario');
				$table->json('accion');
				$table->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tablero.log_acciones');
	}
}
