<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFondosA01 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('fondos.a_01', function (Blueprint $table) {
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
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('fondos.a_01');
	}
}
