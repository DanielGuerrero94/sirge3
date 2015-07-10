<?php

use Illuminate\Database\Migrations\Migration;

class CreacionDeTablasGeoEntidades extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('geo.entidades' , function(Blueprint $table){
			$table->increments('id');
			$table->char('id_provincia' , 2);
			$table->char('id_departamento' , 3);
			$table->char('id_localidad' , 3);
			$table->char('id_entidad' , 2);
			$table->string('nombre_entidad' , 200);

			$table->unique(['id_provincia' , 'id_departamento' , 'id_localidad' , 'id_entidad']);
			$table->index(['id_provincia' , 'id_departamento' , 'id_localidad' , 'id_entidad']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('geo.entidades');
	}
}
