<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssLineasCuidado extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.lineas_cuidado', function(Blueprint $table)
		{
			$table->smallInteger('id_linea_cuidado')->primary();
			$table->text('descripcion')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pss.lineas_cuidado');
	}
}
