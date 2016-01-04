<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresReferentes extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.referentes', function (Blueprint $table) {
			$table->increments('id_referente');
			$table->integer('id_efector');
			$table->string('nombre', 200);
			$table->foreign('id_efector')->references('id_efector')->on('efectores.efectores')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.referentes');
	}
}
