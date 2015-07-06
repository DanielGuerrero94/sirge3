<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableProfeRechazados extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profe.rechazados', function(Blueprint $table)
		{
			$table->char('id_provincia', 2)->nullable();
			$table->string('motivos', 300)->nullable();
			$table->string('registro_rechazado', 300)->nullable();
			$table->integer('lote')->nullable();
		});

		\DB::statement(" ALTER TABLE profe.rechazados ADD COLUMN fecha_rechazo timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone ");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('profe.rechazados');
	}
}
