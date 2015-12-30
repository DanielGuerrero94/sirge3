<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresDescentralizacion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.descentralizacion', function (Blueprint $table) {
			$table->integer('id_efector')->primary();
			$table->char('internet', 1)->default('N');
			$table->char('factura_descentralizada', 1)->default('N');
			$table->char('factura_on_line', 1)->default('N');

			$table->foreign('id_efector')->references('id_efector')->on('efectores.efectores')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.descentralizacion');
	}
}
