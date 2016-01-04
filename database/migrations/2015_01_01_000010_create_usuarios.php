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
			
			$table->increments('id_usuario')->primary();
			$table->string('usuario', 50)->unique();
			$table->string('password', 100);
			$table->string('nombre', 100);
			$table->string('email', 50)->unique();
			$table->char('activo', 1);
			$table->char('id_provincia', 2);
			$table->char('id_entidad', 2);
			$table->integer('id_area')->nullable();
			$table->integer('id_menu');
			$table->string('ruta_imagen', 100)->nullable();
			$table->date('fecha_nacimiento')->nullable();
			$table->string('ocupacion', 100)->nullable();
			$table->string('facebook', 200)->nullable();
			$table->string('twitter', 200)->nullable();
			$table->string('linkedin', 200)->nullable();
			$table->string('google_plus', 200)->nullable();
			$table->string('skype', 200)->nullable();
			$table->string('telefono', 20)->nullable();
			$table->string('cargo', 100)->nullable();
			$table->text('mensaje')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->timestamps();
			$table->rememberToken()->nullable();

			$table->foreign('id_entidad')->references('id')->on('sistema.entidades');
			$table->foreign('id_provincia')->references('id_provincia')->on('geo.provincias');
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
