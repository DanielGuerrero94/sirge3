<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndecPoblacionDepartamentos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('indec.poblacion_departamentos', function(Blueprint $table)
		{
			$table->char('id_provincia', 2);
			$table->char('id_departamento', 3);
			$table->integer('habitantes')->unsigned();
			$table->integer('habitantes_sumar')->unsigned();
			$table->primary(['id_provincia', 'id_departamento']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('indec.poblacion_departamentos');
	}
}
