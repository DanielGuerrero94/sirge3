<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMobileFamiliares extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('mobile.familiares', function (Blueprint $table) {
			$table->integer('id_usuario');
			$table->smallInteger('id_tipo_familiar');
			$table->char('sexo', 1);
			$table->char('tipo_documento', 3);
			$table->string('numero_documento', 14);
			$table->date('fecha_nacimiento');
			$table->primary(['id_usuario', 'id_tipo_familiar', 'sexo', 'tipo_documento', 'numero_documento', 'fecha_nacimiento']);
			$table->foreign('id_usuario')->references('id_usuario')->on('mobile.usuarios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('mobile.familiares');
	}
}
