<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogLogins extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logs.logins', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_usuario')->unsigned();
			$table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
		});

		\DB::statement("ALTER TABLE logs.logins ADD COLUMN fecha_login timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone, ADD COLUMN ip cidr;");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logs.logins');
	}
}
