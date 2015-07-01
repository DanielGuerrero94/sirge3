<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosGeografico extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.beneficiarios_geografico', function(Blueprint $table)
		{
			$table->string('clave_beneficiario', 16)->primary();
			$table->string('calle', 100)->nullable();
			$table->string('numero', 10)->nullable();
			$table->string('manzana', 5)->nullable();
			$table->string('piso', 3)->nullable();
			$table->string('departamento', 3)->nullable();
			$table->string('calle_1', 100)->nullable();
			$table->string('calle_2', 100)->nullable();
			$table->string('barrio', 100)->nullable();
			$table->string('municipio', 100)->nullable();
			$table->string('id_departamento', 3)->nullable();
			$table->string('id_localidad', 3)->nullable();
			$table->string('id_provincia', 2)->nullable();
			$table->string('codigo_postal', 8)->nullable();
			$table->foreign('clave_beneficiario')
			->references('clave_beneficiario')
			->on('beneficiarios.beneficiarios')
			->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('beneficiarios.beneficiarios_geografico');
	}
}
