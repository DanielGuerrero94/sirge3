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
			$table->increments('id_compromiso');
			$table->integer('id_efector');
			$table->string('numero_compromiso', 50);
			$table->string('firmante', 200);
			$table->date('fecha_suscripcion');
			$table->date('fecha_inicio');
			$table->date('fecha_fin');
			$table->string('pago_indirecto', 1)->default('N');
			$table->nullableTimestamps();

			$table->unique(['id_efector', 'numero_compromiso']);
			$table->foreign('id_efector')->references('id_efector')->on('efectores.efectores')->onUpdate('NO ACTION')->onDelete('CASCADE');
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
