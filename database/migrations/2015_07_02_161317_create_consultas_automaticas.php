<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConsultasAutomaticas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('consultas.automaticas', function (Blueprint $table) {
			$table->increments('id_consulta');
			$table->string('nombre');
			$table->string('ruta_sql')->unique();
			$table->string('ruta_destino')->unique();
			$table->string('cuerpo_mail');
		});
		DB::statement('ALTER TABLE consultas.automaticas ADD COLUMN destinatarios character varying[];');
		DB::statement('ALTER TABLE consultas.automaticas ADD COLUMN cronjob character varying;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('consultas.automaticas');
	}
}
