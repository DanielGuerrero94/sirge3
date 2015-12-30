<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosCeb extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.beneficiarios_ceb', function(Blueprint $table)
		{
			$table->increments('id')->primary();
			$table->string('clave_beneficiario', 16);
			$table->integer('periodo');
			$table->char('ceb', 1);
			$table->string('efector', 14);
			$table->date('fecha_ultima_prestacion');
			$table->char('devenga_capita', 1);
			$table->smallInteger('devenga_cantidad_capita');

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
		Schema::drop('beneficiarios.beneficiarios_ceb');
	}
}
