<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePssCodigosTrazadoras extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		
		Schema::create('pss.codigos_trazadoras', function (Blueprint $table) {
			$table->string('codigo_prestacion', 11);
			$table->smallInteger('id_linea_cuidado');
			$table->smallInteger('id_grupo_etario');
			$table->smallInteger('id_trazadora');
			$table->primary(['codigo_prestacion', 'id_linea_cuidado', 'id_grupo_etario', 'id_trazadora']);
			$table->foreign('codigo_prestacion')
			->references('codigo_prestacion')
			->on('pss.codigos')
			->onUpdate('cascade');
			$table->foreign('id_grupo_etario')
			->references('id_grupo_etario')
			->on('pss.grupos_etarios');
			$table->foreign('id_linea_cuidado')
			->references('id_linea_cuidado')
			->on('pss.lineas_cuidado');
			$table->foreign('id_trazadora')
			->references('id_trazadora')
			->on('trazadoras.trazadoras');
		});		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		//Schema::drop('pss.codigos_trazadoras');
	}
}
