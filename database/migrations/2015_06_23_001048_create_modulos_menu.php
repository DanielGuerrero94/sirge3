<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulosMenu extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.modulos_menu', function (Blueprint $table) {
			$table->increments('id_relacion');
			$table->integer('id_menu');
			$table->integer('id_modulo');
			$table->timestamps();
			
			$table->foreign('id_menu')->references('id_menu')->on('sistema.menues');
			$table->foreign('id_modulo')->references('id_modulo')->on('sistema.modulos');
			$table->unique(['id_menu', 'id_modulo']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.modulos_menu');
	}
}
