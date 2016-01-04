<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresTipoTelefono extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.tipo_telefono', function (Blueprint $table) {
			$table->increments('id_tipo_telefono');
			$table->string('descripcion', 100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.tipo_telefono');
	}
}
