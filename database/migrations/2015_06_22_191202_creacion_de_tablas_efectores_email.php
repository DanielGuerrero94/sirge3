<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresEmail extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.email', function (Blueprint $table) {
			$table->increments('id_email');
			$table->integer('id_efector');
			$table->string('email', 200);
			$table->string('observaciones', 100)->nullable();
			
			$table->foreign('id_efector')->references('id_efector')->on('efectores.efectores')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.email');
	}
}
