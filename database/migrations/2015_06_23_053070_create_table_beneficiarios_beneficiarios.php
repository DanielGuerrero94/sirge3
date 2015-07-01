<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBeneficiariosBeneficiarios extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('beneficiarios.beneficiarios', function(Blueprint $table)
		{
			$table->string('clave_beneficiario', 16)->primary();
			$table->string('apellido', 100);
			$table->string('nombre', 100);
			$table->char('tipo_documento', 3);
			$table->char('clase_documento', 1);
			$table->string('numero_documento', 14);
			$table->char('sexo', 1);
			$table->string('pais', 100)->nullable();
			$table->date('fecha_nacimiento');
			$table->date('fecha_inscripcion');
			$table->date('fecha_alta_efectiva')->nullable();
			$table->char('id_provincia_alta', 2)->nullable();
			$table->char('discapacidad', 1);
			$table->string('observaciones', 200)->nullable();
			$table->smallInteger('grupo_actual')->nullable();
			$table->char('grupo_alta', 1)->nullable();
			$table->foreign('clase_documento')
			->references('clase_documento')
			->on('sistema.clases_documento');
			$table->foreign('grupo_actual')
			->references('id_grupo_etario')
			->on('pss.grupos_etarios');
			$table->foreign('sexo')
			->references('sigla')
			->on('sistema.sexos');
			$table->foreign('tipo_documento')
			->references('tipo_documento')
			->on('sistema.tipo_documento');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('beneficiarios.beneficiarios');
	}
}
