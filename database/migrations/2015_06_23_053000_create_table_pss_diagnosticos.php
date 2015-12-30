<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssDiagnosticos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.diagnosticos', function(Blueprint $table)
		{
			$table->smallInteger('id_grupo_diagnostico');
			$table->string('diagnostico', 5)->unique();
			$table->primary(['id_grupo_diagnostico', 'diagnostico']);
			$table->char('matriz_extendida', 1)->nullable();
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
		Schema::drop('pss.diagnosticos');
	}
}
