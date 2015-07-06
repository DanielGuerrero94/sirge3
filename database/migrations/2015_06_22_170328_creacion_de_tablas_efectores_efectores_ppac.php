<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresEfectoresPpac extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.efectores_ppac', function (Blueprint $table) {
			$table->integer('id_efector')->primary();
			$table->string('addenda_perinatal', 1)->nullable();
			$table->date('fecha_addenda_perinatal')->nullable();
			$table->string('perinatal_ac', 1)->nullable();
			$table->string('categoria_obstetrico', 1)->nullable();
			$table->string('categoria_neonatal', 1)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.efectores_ppac');
	}
}
