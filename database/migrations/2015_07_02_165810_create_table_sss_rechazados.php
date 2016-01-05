<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSssRechazados extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
		Schema::create('sss.rechazados', function(Blueprint $table)
		{
			$table->char('id_provincia', 2)->nullable();
			$table->string('motivos', 300)->nullable();
			$table->string('registro_rechazado', 300)->nullable();
			$table->integer('lote')->nullable();
		});

		\DB::statement(" ALTER TABLE sss.rechazados ADD COLUMN fecha_rechazo timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone ");
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Schema::drop('sss.rechazados');
	}
}
