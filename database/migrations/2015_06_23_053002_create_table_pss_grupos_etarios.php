<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssGruposEtarios extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.grupos_etarios', function(Blueprint $table)
		{
			$table->smallInteger('id_grupo_etario')->primary();
			$table->string('sigla', 3)->unique();
			$table->text('edad_min')->nullable();
			$table->text('edad_max')->nullable();
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
		Schema::drop('pss.grupos_etarios');
	}
}
