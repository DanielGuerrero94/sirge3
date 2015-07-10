<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsuarios extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('sistema.usuarios', function (Blueprint $table) {
			$table->increments('id_usuario');
			$table->string('usuario', 20)->unique();
			$table->string('pass', 100);
			$table->string('nombre', 100);
			$table->string('email', 50)->unique();
			$table->char('activo', 1);
			$table->string('id_entidad', 2);
			$table->integer('id_menu');
			$table->integer('id_area');
			$table->string('ruta_imagen', 100);
			$table->date('fecha_nacimiento');
			$table->string('ocupacion', 100);
			$table->string('facebook', 200)->default('#');
			$table->string('twitter', 200)->default('#');
			$table->string('linkedin', 200)->default('#');
			$table->string('google', 200)->default('#');
			$table->string('skype', 200)->default('#');
			$table->string('telefono', 20);
			$table->timestamps();
			$table->enum('sexos', ['M', 'F', 'T']);

			$table->foreign('id_entidad')->references('id_entidad')->on('sistema.provincias');
			$table->foreign('id_menu')->references('id_menu')->on('sistema.menues');
			$table->foreign('id_area')->references('id_area')->on('sistema.areas');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('sistema.usuarios');
	}
}
