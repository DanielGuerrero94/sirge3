<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCodigosGasto extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('fondos.codigos_gasto', function (Blueprint $table) {
			$table->integer('codigo_gasto')->primary();
			$table->string('descripcion', 100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('fondos.codigos_gasto');
	}
}
