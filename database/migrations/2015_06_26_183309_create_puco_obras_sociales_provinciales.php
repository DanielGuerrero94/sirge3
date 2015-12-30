<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePucoObrasSocialesProvinciales extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('puco.obras_sociales_provinciales', function(Blueprint $table)
		{
			$table->integer('codigo_osp')->primary();			
			$table->char('id_provincia', 2);			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('puco.obras_sociales_provinciales');
	}
}
