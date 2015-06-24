<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresDatosGeograficos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.datos_geograficos', function (Blueprint $table) {
			$table->integer('id_efector')->primary();
			$table->string('id_provincia', 2);
			$table->string('id_departamento', 3);
			$table->string('id_localidad', 3);
			$table->string('ciudad', 200)->nullable();
			$table->float('latitud')->nullable();
			$table->float('longitud')->nullable();
			//$table->integer('msnm')->nullable();
			$table->foreign(['id_provincia', 'id_departamento'])
			->references(['id_provincia', 'id_departamento'])
			->on('geo.departamentos')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->foreign(['id_provincia', 'id_departamento', 'id_localidad'])
			->references(['id_provincia', 'id_departamento', 'id_localidad'])
			->on('geo.localidades')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->foreign('id_efector')
			->references('id_efector')
			->on('efectores.efectores')
			->onUpdate('NO ACTION')
			->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.datos_geograficos');
	}
}
