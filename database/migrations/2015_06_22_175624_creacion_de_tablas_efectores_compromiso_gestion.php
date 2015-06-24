<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresCompromisoGestion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.compromiso_gestion', function (Blueprint $table) {
			$table->integer('id_efector');
			$table->string('numero_compromiso', 50);
			$table->string('firmante', 200)->nullable();
			$table->date('fecha_suscripcion')->nullable();
			$table->date('fecha_inicio')->nullable();
			$table->date('fecha_fin')->nullable();
			$table->string('pago_indirecto', 1)->nullable();
			$table->primary(['id_efector', 'numero_compromiso']);
			$table->foreign('id_efector')
			->references('id_efector')
			->on('efectores.efectores')
			->onUpdate('NO ACTION')
			->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.compromiso_gestion');
	}
}
