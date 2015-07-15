<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresEfectores extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.efectores', function (Blueprint $table) {
			$table->increments('id_efector');
			$table->char('cuie', 6)->unique();
			$table->char('siisa', 14)->unique();
			$table->string('nombre', 200);
			$table->string('domicilio', 500);
			$table->string('codigo_postal', 8)->nullable();
			$table->string('denominacion_legal', 200)->nullable();
			$table->integer('id_tipo_efector');
			//$table->string('horario', 20)->nullable();
			$table->char('rural', 1)->default('N');
			//$table->integer('cantidad_camas_internacion')->nullable();
			//$table->integer('cantidad_ambientes')->nullable();
			$table->string('cics', 1)->default('N');
			$table->integer('id_categorizacion');
			$table->integer('id_dependencia_administrativa');
			$table->string('dependencia_sanitaria', 200)->nullable();
			$table->string('codigo_provinicial_efector', 200)->nullable();
			$table->char('integrante', 1)->default('N');
			$table->char('compromiso_gestion', 1)->default('N');
			$table->char('priorizado', 1)->default('N');
			$table->char('ppac', 1)->default('N');
			//$table->char('sumar', 1)->nullable();
			$table->integer('id_estado');
			$table->timestamps();

			$table->foreign('id_tipo_efector')->references('id_tipo_efector')->on('efectores.tipo_efector');
			$table->foreign('id_categorizacion')->references('id_categorizacion')->on('efectores.tipo_categorizacion');
			$table->foreign('id_dependencia_administrativa')->references('id_dependencia_administrativa')->on('efectores.tipo_dependencia_administrativa');
			$table->foreign('id_estado')->references('id_estado')->on('efectores.tipo_estado');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.efectores');
	}
}
