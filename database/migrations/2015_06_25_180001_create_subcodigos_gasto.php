<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubcodigosGasto extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('fondos.subcodigos_gasto', function (Blueprint $table) {
			$table->integer('codigo_gasto');
			$table->integer('subcodigo_gasto');
			$table->string('descripcion', 100);

			$table->primary(['codigo_gasto', 'subcodigo_gasto']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('fondos.subcodigos_gasto');
	}
}
