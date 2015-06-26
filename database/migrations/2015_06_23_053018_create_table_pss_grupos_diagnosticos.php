<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssGruposDiagnosticos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.grupos_diagnosticos', function(Blueprint $table)
		{
			$table->smallInteger('id_grupo_diagnostico')->primary();
			$table->string('sigla', 4)->unique();
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
		Schema::drop('pss.grupos_diagnosticos');
	}
}
