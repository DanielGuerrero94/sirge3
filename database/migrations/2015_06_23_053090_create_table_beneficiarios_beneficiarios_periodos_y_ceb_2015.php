<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosPeriodosYCeb2015 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
		Schema::create('beneficiarios.periodos_y_ceb_2015', function(Blueprint $table)
		{
			$table->string('clave_beneficiario', 16);
			$table->integer('periodo');
			$table->char('activo', 1);
			$table->string('efector_asignado', 14)->nullable();
			$table->char('ceb', 1)->nullable();
			$table->primary(['clave_beneficiario', 'periodo']);
		});
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/*
		Schema::drop('beneficiarios.periodos_y_ceb_2015');
		*/
	}
}
