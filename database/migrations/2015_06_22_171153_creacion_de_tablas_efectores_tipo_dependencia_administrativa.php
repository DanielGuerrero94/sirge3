<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresTipoDependenciaAdministrativa extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.tipo_dependencia_administrativa', function (Blueprint $table) {
			$table->increments('id_dependencia_administrativa')->primary();
			$table->char('sigla', 4);
			$table->string('descripcion', 50);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.tipo_dependencia_administrativa');
	}
}
