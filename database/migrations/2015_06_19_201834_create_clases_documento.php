<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClasesDocumento extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sistema.clases_documento', function(Blueprint $table)
		{
			$table->increments('id_clase_documento');
			$table->char('clase_documento', 1)->unique();
			$table->string('descripcion', 100)->unique();
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sistema.clases_documento');
	}
}
