<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProfeBeneficiarios extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profe.beneficiarios', function(Blueprint $table)
		{
			$table->char('tipo_documento', 3)->nullable();
			$table->bigInteger('numero_documento')->nullable();
			$table->string('nombre_apellido', 60)->nullable();
			$table->char('sexo', 1)->nullable();
			$table->date('fecha_nacimiento')->nullable();
			$table->date('fecha_alta')->nullable();
			$table->bigInteger('id_beneficiario_profe')->nullable();
			$table->smallInteger('id_parentezco')->nullable();
			$table->char('ley_aplicada', 2)->nullable();
			$table->date('fecha_desde')->nullable();
			$table->date('fecha_hasta')->nullable();
			$table->char('id_provincia', 2)->nullable();
			$table->integer('codigo_os')->unsigned()->default(997001);
			$table->integer('lote')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profe.beneficiarios');
	}
}
