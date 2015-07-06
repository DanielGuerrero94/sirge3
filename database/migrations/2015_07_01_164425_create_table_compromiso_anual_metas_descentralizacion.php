<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompromisoAnualMetasDescentralizacion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compromiso_anual.metas_descentralizacion', function(Blueprint $table)
		{
			$table->char('id_provincia', 2);
			$table->float('primer_semestre')->nullable();
			$table->float('segundo_semestre')->nullable();
			$table->integer('year');
			$table->primary(['id_provincia', 'year']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('compromiso_anual.metas_descentralizacion');
	}
}
