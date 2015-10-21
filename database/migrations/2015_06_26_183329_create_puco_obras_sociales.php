<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePucoObrasSociales extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('puco.obras_sociales', function(Blueprint $table)
		{
			$table->increments('id_osp');
			$table->integer('grupo_os');
			$table->integer('codigo_osp')->unique();
			$table->string('sigla', 20)->nullable();
			$table->text('nombre')->nullable();
			$table->foreign('grupo_os')->references('grupo_os')->on('puco.grupos_obras_sociales');
		});

		\DB::statement('ALTER TABLE puco.obras_sociales DROP CONSTRAINT obras_sociales_pkey');
		
		Schema::table('puco.obras_sociales', function(Blueprint $table)
		{
			$table->primary(['id_osp', 'codigo_osp']);			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('puco.obras_sociales');
	}
}
