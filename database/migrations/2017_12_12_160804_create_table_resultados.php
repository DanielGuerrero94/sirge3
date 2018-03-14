<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableResultados extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('tablero.ingresos', function (Blueprint $table) {
				$table->increments('id');
				$table->string('indicador', 5);
				$table->string('periodo', 7);
				$table->char('id_provincia', 2);
				$table->text('numerador')->nullable();
				$table->text('denominador')->nullable();
				$table->jsonb('observaciones')->nullable();
				$table->integer('lote');
				$table->unique('indicador', 'periodo', 'provincia');
				$table->index('periodo');
				$table->index('lote');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('tablero.ingresos');
	}
}
