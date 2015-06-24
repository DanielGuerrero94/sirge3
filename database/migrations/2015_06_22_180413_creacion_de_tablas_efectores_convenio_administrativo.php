<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresConvenioAdministrativo extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.convenio_administrativo', function (Blueprint $table) {
			$table->integer('id_efector');
			$table->string('numero_compromiso', 50);
			$table->string('firmante', 200)->nullable();
			$table->string('nombre_tercer_adminstrador', 200)->nullable();
			$table->string('codigo_tercer_administrador', 50)->nullable();
			$table->date('fecha_suscripcion')->nullable();
			$table->date('fecha_inicio')->nullable();
			$table->date('fecha_fin')->nullable();
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
		Schema::drop('efectores.convenio_administrativo');
	}
}
