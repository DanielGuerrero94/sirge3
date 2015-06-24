<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresEfectoresInicial extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.efectores_inicial', function (Blueprint $table) {
			$table->increments('id_efector');
			$table->string('cuie', 6);
			$table->string('siisa', 14)->nullable();
			$table->string('nombre', 200);
			$table->string('domicilio', 500);
			$table->string('codigo_postal', 8)->nullable();
			$table->string('denominacion_legal', 200)->nullable();
			$table->integer('id_tipo_efector');
			$table->string('horario', 20)->nullable();
			$table->string('rural', 1)->nullable();
			$table->integer('cantidad_camas_internacion')->nullable();
			$table->integer('cantidad_ambientes')->nullable();
			$table->string('cics', 1)->nullable();
			$table->integer('id_categorizacion')->nullable();
			$table->integer('id_dependencia_administrativa');
			$table->string('dependencia_sanitaria', 200)->nullable();
			$table->string('codigo_provincial_efector', 200)->nullable();
			$table->string('integrante', 1)->nullable();
			$table->string('compromiso_gestion', 1)->nullable();
			$table->string('alto_impacto', 1)->nullable();
			$table->string('ppac', 1)->nullable();
			$table->string('sumar', 1);
			$table->integer('id_estado')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.efectores_inicial');
	}
}
