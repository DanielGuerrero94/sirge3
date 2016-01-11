<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultasEstandar extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		/*
		Schema::create('consultas.estandar', function (Blueprint $table) {
			$table->increments('id_consulta');
			$table->string('nombre')->unique();
			$table->string('formulario');
			$table->string('descripcion');
			$table->string('ruta_sql');
		});
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//Schema::drop('consultas.estandar');
	}
}
