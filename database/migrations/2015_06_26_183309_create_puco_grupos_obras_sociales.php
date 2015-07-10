<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePucoGruposObrasSociales extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('puco.grupos_obras_sociales', function(Blueprint $table)
		{
			$table->integer('grupo_os')->primary();
			$table->string('nombre_grupo', 200);
			$table->char('id_provincia', 2);
			$table->foreign('id_provincia')->references('id_provincia')->on('sistema.provincias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('puco.grupos_obras_sociales');
	}
}
