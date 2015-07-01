<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComprobantesMetasCodigosValidos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comprobantes.metas_codigos_validos', function(Blueprint $table)
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
		Schema::drop('comprobantes.metas_codigos_validos');
	}
}
