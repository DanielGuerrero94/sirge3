<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableCargasRechazadas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tablero.cargas_rechazadas', function (Blueprint $table) {
				$table->integer('lote')->primary();
				$table->jsonb('registros')->nullable();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tablero.cargas_rechazadas');
	}
}
