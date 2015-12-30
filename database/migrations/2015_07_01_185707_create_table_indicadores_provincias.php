<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndicadoresProvincias extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
		Schema::create('indicadores.provincias', function(Blueprint $table)
		{
			$table->char('id_provincia', 2)->primary();
			$table->string('provincia', 40);
		});
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/*
		Schema::drop('indicadores.provincias');
		*/
	}
}
