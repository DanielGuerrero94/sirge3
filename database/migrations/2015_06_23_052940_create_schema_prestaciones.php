<?php

use Illuminate\Database\Migrations\Migration;

class CreateSchemaPrestaciones extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement('CREATE SCHEMA prestaciones');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('DROP SCHEMA prestaciones CASCADE;');
	}
}
