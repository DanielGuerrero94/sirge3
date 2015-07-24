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
		Schema::create('logs.queries_dinamicos', function(Blueprint $table)
		{
			$table->increments('id_query_dinamico');
			$table->integer('id_usuario')->unsigned();
			$table->text('consulta')->nullable();
			$table->char('consulta_ok', 1)->nullable();
			$table->char('descarga', 1)->nullable()->default('N');
			$table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
		});

		\DB::statement('ALTER TABLE logs.queries_dinamicos ADD COLUMN "timestamp" timestamp without time zone');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logs.queries_dinamicos');
	}
}
