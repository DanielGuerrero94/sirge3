<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadorasTrazadoras extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trazadoras.trazadoras', function(Blueprint $table)
		{
			$table->smallInteger('id_trazadora')->primary();
			$table->string('nombre', 200);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trazadoras.trazadoras');
	}
}
