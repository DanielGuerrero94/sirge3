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
			$table->string('id_provincia', 2);
			$table->primary('id_provincia');
			$table->string('geojson_provincia', 5);
			$table->foreign('id_provincia')->references('id_entidad')->on('sistema.entidades');
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
