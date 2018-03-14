<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableAdministracionTablero extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tablero.administracion', function (Blueprint $table) {
				$table->increments('id');
				$table->string('periodo', 7);
				$table->char('provincia', 2);
				$table->char('estado', 1);
				$table->integer('usuario_accion')->nullable();
				$table->timestamps();
				$table->unique(['periodo', 'provincia', 'estado'], 'periodo_provincia_estado_unq');
				$table->index('periodo', 'administracion_periodo_idx');
				$table->foreign('estado')->references('id_estado')->on('sistema.estados');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::create('tablero.administracion');
	}
}
