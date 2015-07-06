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
			$table->string('cuie', 6)->unique();
			$table->string('siisa', 14)->nullable();
			$table->string('nombre', 200);
			$table->string('domicilio', 500);
			$table->string('codigo_postal', 8)->nullable();
			$table->string('denominacion_legal', 200)->nullable();
			$table->integer('id_tipo_efector');
			$table->foreign('id_tipo_efector')
			->references('id_tipo_efector')->on('efectores.tipo_efector')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->string('horario', 20)->nullable();
			$table->string('rural', 1)->nullable();
			$table->integer('cantidad_camas_internacion')->nullable();
			$table->integer('cantidad_ambientes')->nullable();
			$table->string('cics', 1)->nullable();
			$table->integer('id_categorizacion')->nullable();
			$table->foreign('id_categorizacion')
			->references('id_categorizacion')->on('efectores.tipo_categorizacion')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->integer('id_dependencia_administrativa');
			$table->foreign('id_dependencia_administrativa')
			->references('id_dependencia_administrativa')->on('efectores.tipo_dependencia_administrativa')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->string('dependencia_sanitaria', 200)->nullable();
			$table->string('codigo_provinicial_efector', 200)->nullable();
			$table->string('integrante', 1)->nullable();
			$table->string('compromiso_gestion', 1)->nullable();
			$table->string('priorizado', 1)->default('N');
			$table->string('ppac', 1)->nullable();
			$table->string('sumar', 1)->nullable();
			$table->integer('id_estado')->nullable();
			$table->foreign('id_estado')
			->references('id_estado')->on('efectores.tipo_estado')
			->onUpdate('NO ACTION')
			->onDelete('NO ACTION');
			$table->timestamps();
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
