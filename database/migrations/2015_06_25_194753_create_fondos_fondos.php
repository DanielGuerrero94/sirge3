<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFondosFondos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('fondos.fondos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('efector', 14);
			$table->date('fecha_gasto');
			$table->integer('periodo');
			$table->string('numero_comprobante', 50);
			$table->tinyInteger('codigo_gasto');
			$table->tinyInteger('subcodigo_gasto');
			$table->string('efector_cesion')->nulleable();
			$table->decimal('monto');
			$table->text('concepto')->nulleable();
			$table->integer('lote');

			$table->foreign('efector')->references('cuie')->on('efectores.efectores');
			$table->foreign('codigo_gasto')->references('codigo_gasto')->on('fondos.codigos_gasto');
			DB::statement('ALTER TABLE fondos.fondos ADD CONSTRAINT fkey_subcodigo_gasto FOREIGN KEY (codigo_gasto , subcodigo_gasto) REFERENCES fondos.subcodigos_gasto (codigo_gasto , subcodigo_gasto) MATCH SIMPLE ON UPDATE NO ACTION ON DELETE NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('fondos.fondos');
	}
}
