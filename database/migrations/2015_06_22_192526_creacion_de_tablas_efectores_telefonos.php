<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresTelefonos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.telefonos', function (Blueprint $table) {
			$table->increments('id_telefono');
			$table->integer('id_efector');
			$table->string('numero_telefono', 200);
			$table->integer('id_tipo_telefono');
			$table->string('observaciones', 100)->nullable();
			$table->foreign('id_efector')
			->references('id_efector')
			->on('efectores.efectores')
			->onUpdate('NO ACTION')
			->onDelete('cascade');
			$table->foreign('id_tipo_telefono')
			->references('id_tipo_telefono')
			->on('efectores.tipo_telefono')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.telefonos');
	}
}
