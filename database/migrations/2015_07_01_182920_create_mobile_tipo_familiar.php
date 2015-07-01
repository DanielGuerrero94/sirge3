<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMobileTipoFamiliar extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('mobile.tipo_familiar', function (Blueprint $table) {
			$table->increments('id_tipo_familiar');
			$table->string('descripcion', 200);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('mobile.tipo_familiar');
	}
}
