<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssCodigosCeb extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.codigos_ceb', function(Blueprint $table)
		{
			$table->string('codigo_prestacion', 11);
			$table->smallInteger('id_grupo_etario');
			$table->primary(['codigo_prestacion', 'id_grupo_etario']);
			$table->foreign('codigo_prestacion')
			->references('codigo_prestacion')
			->on('pss.codigos')
			->onUpdate('cascade');
			$table->foreign('id_grupo_etario')
			->references('id_grupo_etario')
			->on('pss.grupos_etarios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pss.codigos_ceb');
	}
}
