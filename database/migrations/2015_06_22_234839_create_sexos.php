<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSexos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.sexos', function (Blueprint $table) {
			$table->increments('id_sexo');
			$table->char('sigla', 1)->unique();
			$table->string('descripcion', 100);
			//$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.sexos');
	}
}
