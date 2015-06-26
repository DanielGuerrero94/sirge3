<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePucoGruposObrasSociales extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('puco.grupos_obras_sociales', function (Blueprint $table) {
			$table->integer('grupo_os')->primary();
			$table->string('nombre_grupo', 200);
			$table->char('id_entidad', 2);

			$table->foreig('id_entidad')->references('id_entidad')->on('sistema.entidades');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('puco.grupos_obras_sociales');
	}
}
