<?php

use Illuminate\Database\Migrations\Migration;

class CreacionSchemaEfectores extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement('CREATE SCHEMA efectores');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('DROP SCHEMA efectores');
	}
}
