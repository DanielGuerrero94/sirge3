<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosIndigenas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.indigenas', function(Blueprint $table)
		{
			$table->string('clave_beneficiario', 16)->primary();
			$table->char('declara_indigena', 1);
			$table->smallInteger('id_lengua');
			$table->smallInteger('id_tribu');

			$table->index('clave_beneficiario');
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
		Schema::drop('beneficiarios.indigenas');
	}
}
