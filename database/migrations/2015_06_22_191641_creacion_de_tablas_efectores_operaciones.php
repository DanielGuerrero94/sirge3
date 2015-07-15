<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreacionDeTablasEfectoresOperaciones extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('efectores.operaciones' , function (Blueprint $table){
			$table->increments('id_operacion');
			$table->integer('id_efector');
			$table->integer('id_usuario');
			$table->timestamp('fecha')->default(DB::raw('now()::timestamp(0)'));
			$table->text('observaciones');

			$table->foreign('id_efector')->references('id_efector')->on('efectores.efectores')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('id_usuario')->references('id_usuario')->on('sistema.usuarios');
		});
	}
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('efectores.operaciones');
	}
}
