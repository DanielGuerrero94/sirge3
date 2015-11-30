<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComprobantesComprobantes extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comprobantes.comprobantes', function(Blueprint $table)
		{
			$table->increments('id_comprobante');
			//$table->char('id_provincia', 2);
			$table->string('efector', 14);
			$table->string('numero_comprobante', 50);
			$table->char('tipo_comprobante', 2);
			$table->date('fecha_comprobante');
			$table->date('fecha_recepcion');
			$table->date('fecha_notificacion');
			$table->date('fecha_liquidacion');
			$table->date('fecha_debito_bancario');
			$table->decimal('importe');
			$table->decimal('importe_pagado');
			$table->string('factura_debitada', 50);
			$table->text('concepto');
			$table->integer('lote');

			$table->foreign('lote')->references('lote')->on('sistema.lotes');
			$table->unique(['id_provincia','numero_comprobante','tipo_comprobante','efector']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('comprobantes.comprobantes');
	}
}
