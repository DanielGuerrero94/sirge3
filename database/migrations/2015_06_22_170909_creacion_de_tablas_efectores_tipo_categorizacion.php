<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresTipoCategorizacion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.tipo_categorizacion', function (Blueprint $table) {
			$table->increments('id_categorizacion');
			$table->string('sigla', 6);
			$table->string('descripcion', 100)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.tipo_categorizacion');
	}
}
