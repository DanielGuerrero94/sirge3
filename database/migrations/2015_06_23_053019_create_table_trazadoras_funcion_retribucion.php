<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadorasFuncionRetribucion extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*Schema::create('trazadoras.funcion_retribucion', function(Blueprint $table)
		{
			$table->string('id_provincia', 2);
			$table->smallInteger('id_trazadora');
			$table->float('tasa_cobertura')->nullable();
			$table->float('retribucion_minima')->nullable();
			$table->float('meta')->nullable();
			$table->float('retribucion_maxima')->nullable();
			$table->float('denominador_casos')->nullable();
			$table->float('tasa_cobertura_minima_casos')->nullable();
			$table->float('meta_casos')->nullable();
			$table->primary(['id_provincia', 'id_trazadora']);
		});
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('trazadoras.funcion_retribucion');
	}
}
