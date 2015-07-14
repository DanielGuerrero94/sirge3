<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiariosParientes extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.beneficiarios_parientes', function(Blueprint $table)
		{
			$table->string('clave_beneficiario', 16)->primary();
			$table->string('madre_tipo_documento', 3);
			$table->string('madre_numero_documento', 14);
			$table->string('madre_apellido', 100);
			$table->string('madre_nombre', 100);
			$table->string('padre_tipo_documento', 3);
			$table->string('padre_numero_documento', 14);
			$table->string('padre_apellido', 100);
			$table->string('padre_nombre', 100);
			$table->string('otro_tipo_documento', 13);
			$table->string('otro_numero_documento', 14);
			$table->string('otro_apellido', 100);
			$table->string('otro_nombre', 100);
			$table->smallInteger('otro_tipo_relacion');
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
		Schema::drop('beneficiarios.beneficiarios_parientes');
	}
}