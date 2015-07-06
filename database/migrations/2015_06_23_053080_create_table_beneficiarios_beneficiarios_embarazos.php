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
		Schema::create('beneficiarios.beneficiarios_embarazos', function(Blueprint $table)
		{
			$table->string('clave_beneficiario', 16);
			$table->increments('id_embarazo');
			$table->date('fecha_diagnostico_embarazo');
			$table->smallInteger('semanas_embarazo');
			$table->date('fecha_probable_parto')->nullable();
			$table->date('fecha_efectiva_parto')->nullable();
			$table->date('fum')->nullable();
			$table->integer('periodo');
		});

		\DB::statement('ALTER TABLE beneficiarios.beneficiarios_embarazos DROP CONSTRAINT beneficiarios_embarazos_pkey');

		Schema::table('beneficiarios.beneficiarios_embarazos', function(Blueprint $table)
		{
			$table->primary(['clave_beneficiario', 'id_embarazo']);
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
		Schema::drop('beneficiarios.beneficiarios_embarazos');
	}
}
