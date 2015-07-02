<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileReporteProblemas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mobile.reporte_problemas', function(Blueprint $table)
		{
			$table->increments('id_problema');
			$table->integer('id_usuario');
			$table->smallInteger('tipo_problema');
			$table->text('problema');
			$table->timestamp('reportado')->default(DB::raw('now()::timestamp(0)'));

			$table->foreign('id_usuario')->references('id_usuario')->on('mobile.usuarios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mobile.reporte_problemas');
	}
}
