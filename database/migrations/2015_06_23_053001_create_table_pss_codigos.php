<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePssCodigos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('pss.codigos', function (Blueprint $table) {
			$table->string('codigo_prestacion', 11)->primary();
			$table->string('tipo', 2)->nullable();
			$table->string('objeto', 4)->nullable();
			$table->string('diagnostico', 5)->nullable();
			$table->string('codigo_logico', 1)->nullable();
			$table->text('descripcion_grupal', 1);
			$table->timestamp('inserted_at')->default(DB::raw('now()');
			$table->timestamp('updated_at')->default(DB::raw('now()');

			$table->foreign('diagnostico')->references('diagnostico')->on('pss.diagnosticos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('pss.codigos');
	}
}
