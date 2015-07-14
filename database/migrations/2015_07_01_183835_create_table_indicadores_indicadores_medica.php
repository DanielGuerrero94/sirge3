<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndicadoresIndicadoresMedica extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indicadores.indicadores_medica', function(Blueprint $table)
		{
			$table->char('id_provincia', 2);
			$table->integer('periodo');
			$table->string('codigo_indicador', 6);
			$table->integer('resultado')->unsigned()->default(0);
			$table->primary(['id_provincia', 'periodo', 'codigo_indicador']);
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
		Schema::drop('indicadores.indicadores_medica');
	}
}