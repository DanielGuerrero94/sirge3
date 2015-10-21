<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosContacto extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.beneficiarios_contacto', function(Blueprint $table)
		{
			$table->string('clave_beneficiario', 16);
			$table->string('telefono', 50)->nullable();
			$table->string('celular', 50)->nullable();
			$table->string('email', 50)->nullable();
			$table->smallInteger('modificado')->default(0)->nullable();

			$table->primary('clave_beneficiario');
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
		Schema::drop('beneficiarios.beneficiarios_contacto');
	}
}
