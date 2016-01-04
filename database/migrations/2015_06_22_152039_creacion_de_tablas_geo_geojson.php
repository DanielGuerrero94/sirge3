<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreacionDeTablasGeoGeojson extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('geo.geojson', function(Blueprint $table)
		{
			$table->char('id_provincia', 2)->primary();
			$table->char('geojson_provincia', 5)->unique();
			$table->foreign('id_provincia')->references('id_provincia')->on('geo.provincias');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('geo.geojson');
	}
}
