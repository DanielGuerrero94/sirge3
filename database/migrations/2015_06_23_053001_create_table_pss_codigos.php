<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssCodigos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.codigos', function(Blueprint $table)
		{
			$table->string('codigo_prestacion', 11)->primary();
			$table->string('tipo', 2);
			$table->string('objeto', 4);
			$table->string('diagnostico', 5)->unique();
			$table->string('codigo_logico', 1)->nulleable();
			
			$table->foreign('diagnostico')->references('diagnostico')->on('pss.diagnosticos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pss.codigos');
	}
}
