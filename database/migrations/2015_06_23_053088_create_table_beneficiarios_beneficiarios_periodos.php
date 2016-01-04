<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosPeriodos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.periodos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('clave_beneficiario', 16);
			$table->integer('periodo');
			$table->char('activo', 1);
			$table->string('efector_asignado', 14)->nullable()->index();
			$table->string('efector_habitual', 14)->nullable()->index();
			$table->integer('id_ingreso');
			$table->char('embarazo', 1)->default('N');
			$table->primary(['clave_beneficiario', 'periodo']);
			
			$table->index(['clave_beneficiario', 'periodo']);
			$table->index(['clave_beneficiario', 'periodo' , 'activo']);
			$table->unique(['clave_beneficiario', 'periodo']);
			$table->foreign('clave_beneficiario')->references('clave_beneficiario')->on('beneficiarios.beneficiarios')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('beneficiarios.periodos');
	}
}
