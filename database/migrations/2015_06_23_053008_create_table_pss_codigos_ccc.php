<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePssCodigosCcc extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pss.codigos_ccc', function(Blueprint $table)
		{
			$table->string('codigo_prestacion', 11);
			$table->smallInteger('id_linea_cuidado');
			$table->smallInteger('id_grupo_etario');
			$table->smallInteger('id_modulo');
			$table->text('patologia')->nullable();
			$table->primary(['codigo_prestacion', 'id_linea_cuidado', 'id_grupo_etario', 'id_modulo']);
			$table->foreign('codigo_prestacion')
			->references('codigo_prestacion')
			->on('pss.codigos')
			->onUpdate('cascade')
			->onDelete('NO ACTION');
			$table->foreign('id_linea_cuidado')
			->references('id_linea_cuidado')
			->on('pss.lineas_cuidado')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->foreign('id_grupo_etario')
			->references('id_grupo_etario')
			->on('pss.grupos_etarios')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->foreign('id_modulo')
			->references('id_modulo')
			->on('pss.modulos_ccc')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('pss.codigos_ccc');
	}
}
