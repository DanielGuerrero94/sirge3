<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosEmbarazos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.embarazos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('clave_beneficiario', 16);
			$table->date('fecha_diagnostico_embarazo');
			$table->smallInteger('semanas_embarazo');
			$table->date('fecha_probable_parto')->nullable();
			$table->date('fecha_efectiva_parto')->nullable();
			$table->date('fum')->nullable();
			$table->integer('periodo');

			$table->unique(['clave_beneficiario', 'id']);
			$table->index(['clave_beneficiario', 'id']);
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
		Schema::drop('beneficiarios.embarazos');
	}
}
