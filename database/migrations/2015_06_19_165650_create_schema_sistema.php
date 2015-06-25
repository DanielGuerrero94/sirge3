<?php

use Illuminate\Database\Migrations\Migration;

class CreateSchemaSistema extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement('CREATE SCHEMA sistema');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('DROP SCHEMA sistema CASCADE;');
	}
}
