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
			$table->string('efector', 14);
			$table->float('c1')->nullable();
			$table->float('c2')->nullable();
			$table->float('c3')->nullable();
			$table->string('indicador', 5);
			$table->primary(['efector', 'indicador']);
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
