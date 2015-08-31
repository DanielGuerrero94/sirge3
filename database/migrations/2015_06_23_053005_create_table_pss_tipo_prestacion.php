<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePssTiposPrestacion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('pss.tipo_prestacion', function (Blueprint $table) {
			$table->string('tipo_prestacion', 2)->primary();
			$table->text('descripcion')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('pss.tipos_prestacion');
	}
}
