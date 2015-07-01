<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePucoResumenPuco extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('puco.resumen_puco', function(Blueprint $table)
		{
			$table->increments('id_puco');
			$table->integer('periodo');
			$table->string('clave', 8);
			$table->bigInteger('registros');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('puco.resumen_puco');
	}
}
