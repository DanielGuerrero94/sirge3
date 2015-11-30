<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDdjjSirge extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ddjj.sirge', function(Blueprint $table)
		{
			$table->increments('id_impresion');			
		});

		\DB::statement("ALTER TABLE ddjj.sirge ADD COLUMN fecha_impresion timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone, ADD COLUMN lote integer[];");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ddjj.sirge');
	}
}
