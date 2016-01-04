<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndicadoresIndicadoresPriorizados extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indicadores.indicadores_priorizados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('efector', 6);
			//$table->string('nombre', 200);
			$table->integer('periodo')->unsigned();
			$table->string('indicador', 5);
			$table->integer('numerador')->unsigned()->default(0);
			$table->char('id_provincia', 2);
			$table->integer('denominador')->unsigned()->default(0);

			$table->unique(['efector', 'periodo', 'indicador']);
			$table->foreign('efector')->references('cuie')->on('efectores.efectores');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('indicadores.indicadores_priorizados');
	}
}
