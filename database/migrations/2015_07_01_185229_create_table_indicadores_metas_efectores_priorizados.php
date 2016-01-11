<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndicadoresMetasEfectoresPriorizados extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indicadores.metas_efectores_priorizados', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('efector', 14);
			$table->string('indicador', 5);
			$table->float('base')->nullable();
			$table->float('c1')->nullable();
			$table->float('c2')->nullable();
			$table->float('c3')->nullable();

			$table->unique(['efector', 'indicador']);
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
		Schema::drop('indicadores.metas_efectores_priorizados');
	}
}
