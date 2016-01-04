<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosBajas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.beneficiarios_bajas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('clave_beneficiario', 16);
			$table->integer('periodo');
			$table->smallInteger('motivo')->nullable();
			$table->string('mensaje', 100)->nullable();

			$table->index(['clave_beneficiario', 'periodo']);
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
		Schema::drop('beneficiarios.beneficiarios_bajas');
	}
}
