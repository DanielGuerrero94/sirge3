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
			$table->char('clase_documento', 1);
			$table->string('descripcion', 100);
			$table->timestamps();
			//$table->unique(['id_clase_documento', 'clase_documento']);
		});

		\DB::statement('ALTER TABLE sistema.clases_documento DROP CONSTRAINT clases_documento_pkey');

		Schema::table('sistema.clases_documento', function(Blueprint $table)
		{
			$table->primary('clase_documento');
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
