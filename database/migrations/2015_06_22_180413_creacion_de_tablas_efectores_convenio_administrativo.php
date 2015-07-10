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
			$table->increments('id_convenio');
			$table->integer('id_efector');
			$table->string('numero_compromiso', 50);
			$table->string('firmante', 200);
			$table->string('nombre_tercer_adminstrador', 200)->nullable();
			$table->string('codigo_tercer_administrador', 50)->nullable();
			$table->date('fecha_suscripcion');
			$table->date('fecha_inicio');
			$table->date('fecha_fin');

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
		Schema::drop('efectores.convenio_administrativo');
	}
}
