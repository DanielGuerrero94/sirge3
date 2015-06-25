<?php

use Illuminate\Database\Migrations\Migration;

class CreateSchemaGeo extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement('CREATE SCHEMA geo');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('DROP SCHEMA geo CASCADE;');
	}
}
