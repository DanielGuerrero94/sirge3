<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableLogsLogQueriesDinamicos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logs.log_queries_dinamicos', function(Blueprint $table)
		{
			$table->increments('id_query_dinamico');
			$table->integer('id_usuario')->unsigned();
			$table->text('consulta')->nullable();
			$table->char('consulta_ok', 1)->nullable();
			$table->char('descarga', 1)->nullable()->default('N');
			$table->foreign('id_usuario')
			->references('id_usuario')
			->on('sistema.usuarios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logs.log_queries_dinamicos');
	}
}
