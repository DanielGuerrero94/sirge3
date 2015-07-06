<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssModulosCcc extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.modulos_ccc', function(Blueprint $table)
		{
			$table->smallInteger('id_modulo')->primary();
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
		Schema::drop('pss.modulos_ccc');
	}
}
