<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndecPoblacion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indec.poblacion', function(Blueprint $table)
		{
			$table->char('id_provincia', 2)->primary();
			$table->integer('habitantes')->unsigned();
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
		Schema::drop('indec.poblacion');
	}
}
