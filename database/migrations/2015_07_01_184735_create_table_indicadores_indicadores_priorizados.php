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
			$table->string('efector', 8);
			$table->integer('periodo')->unsigned();
			$table->integer('numerador')->unsigned()->default(0);
			$table->char('id_provincia', 2);
			$table->string('indicador', 5);
			$table->integer('denominador')->unsigned()->default(0);
			$table->string('nombre', 200);
			$table->primary(['efector', 'periodo', 'indicador']);
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
