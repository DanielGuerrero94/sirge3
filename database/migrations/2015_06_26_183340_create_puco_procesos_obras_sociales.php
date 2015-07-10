<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePucoProcesosObrasSociales extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('puco.procesos_obras_sociales', function(Blueprint $table)
		{
			$table->char('id_entidad', 2);
			$table->integer('codigo_osp');
			$table->integer('periodo');
			$table->char('puco', 1)->default('N');
			$table->integer('registros_in');
			$table->integer('registros_out');
			$table->primary(['id_entidad', 'codigo_osp', 'periodo', 'puco']);
			$table->foreign('id_entidad')->references('id_entidad')->on('sistema.provincias');
			$table->foreign('codigo_osp')->references('codigo_osp')->on('puco.obras_sociales');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('puco.procesos_obras_sociales');
	}
}
