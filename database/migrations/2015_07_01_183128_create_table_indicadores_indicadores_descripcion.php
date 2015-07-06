<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndicadoresIndicadoresDescripcion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indicadores.indicadores_descripcion', function(Blueprint $table)
		{
			$table->string('indicador', 8)->primary();
			$table->text('descripcion');
			$table->text('numerador')->nullable();
			$table->text('denominador')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('indicadores.indicadores_descripcion');
	}
}
