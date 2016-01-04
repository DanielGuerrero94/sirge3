<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresTipoEfector extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.tipo_efector', function (Blueprint $table) {
			$table->increments('id_tipo_efector');
			$table->char('sigla', 3);
			$table->string('descripcion', 50);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.tipo_efector');
	}
}
