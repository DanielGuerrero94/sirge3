<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrestaciones extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('prestaciones.prestaciones', function(Blueprint $table)
		{
			$table->increments('id');			
			$table->char('estado', 1);
			$table->string('efector', 14);
			$table->string('numero_comprobante', 50);
			$table->string('codigo_prestacion', 11);
			$table->string('subcodigo_prestacion', 3)->nullable();
			$table->float('precio_unitario');
			$table->date('fecha_prestacion');
			$table->string('clave_beneficiario', 16);
			$table->char('tipo_documento', 3)->nullable();
			$table->char('clase_documento', 1)->nullable();
			$table->string('numero_documento', 14)->nullable();
			$table->smallInteger('orden');
			$table->integer('lote');
			$table->jsonb('datos_reportables')->nullable();
			//$table->string('datos_reportables')->nullable();
			
			$table->foreign('efector')->references('cuie')->on('efectores.efectores');
			$table->foreign('codigo_prestacion')->references('codigo_prestacion')->on('pss.codigos');
			$table->foreign('clave_beneficiario')->references('clave_beneficiario')->on('beneficiarios.beneficiarios');
			$table->foreign('lote')->references('lote')->on('sistema.lotes');

			$table->unique(['numero_comprobante', 'codigo_prestacion', 'subcodigo_prestacion', 'fecha_prestacion', 'clave_beneficiario', 'orden', 'efector']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('prestaciones.prestaciones');
	}
}
