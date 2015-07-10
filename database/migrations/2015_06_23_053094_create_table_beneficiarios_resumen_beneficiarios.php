<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosResumenBeneficiarios extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.resumen_beneficiarios', function(Blueprint $table)
		{
			$table->char('id_provincia', 2);
			$table->integer('periodo');
			$table->integer('beneficiarios')->default(0);
			$table->integer('beneficiarios_ceb')->default(0);
			$table->integer('mujeres')->default(0);
			$table->integer('mujeres_ceb')->default(0);
			$table->integer('hombres')->default(0);
			$table->integer('hombres_ceb')->default(0);
			$table->integer('beneficiarios_05')->default(0);
			$table->integer('beneficiarios_69')->default(0);
			$table->integer('beneficiarios_1019')->default(0);
			$table->integer('beneficiarios_2064')->default(0);
			$table->primary(['id_provincia', 'periodo']);
			$table->foreign('id_provincia')
			->references('id_provincia')
			->on('sistema.provincias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('beneficiarios.resumen_beneficiarios');
	}
}
