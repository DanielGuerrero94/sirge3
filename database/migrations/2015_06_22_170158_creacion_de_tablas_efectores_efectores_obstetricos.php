<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresEfectoresObstetricos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.efectores_obstetricos', function (Blueprint $table) {
			$table->increments('id');
			$table->char('siisa', 14);
			$table->integer('id_categoria');
			$table->unique(['siisa','id_categoria']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.efectores_obstetricos');
	}
}
