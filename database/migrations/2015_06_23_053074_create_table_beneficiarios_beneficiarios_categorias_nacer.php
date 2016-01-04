<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosCategoriasNacer extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.beneficiarios_categorias_nacer', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('clave_beneficiario', 16);
			$table->integer('periodo');
			$table->smallInteger('tipo_categoria')->nullable();			
			$table->unique(['periodo','clave_beneficiario']);
			//$table->index(['clave_beneficiario','periodo']);
			
			$table->foreign('clave_beneficiario')->references('clave_beneficiario')->on('beneficiarios.beneficiarios')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('beneficiarios.beneficiarios_categorias_nacer');
	}
}
