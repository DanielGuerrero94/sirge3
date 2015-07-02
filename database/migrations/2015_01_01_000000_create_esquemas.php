<?php

use Illuminate\Database\Migrations\Migration;

class CreateEsquemas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		DB::statement('CREATE SCHEMA beneficiarios;');
		DB::statement('CREATE SCHEMA comprobantes;');
		DB::statement('CREATE SCHEMA compromiso_anual;');
		DB::statement('CREATE SCHEMA consultas;');
		DB::statement('CREATE SCHEMA ddjj;');
		DB::statement('CREATE SCHEMA efectores;');
		DB::statement('CREATE SCHEMA fondos;');
		DB::statement('CREATE SCHEMA geo;');
		DB::statement('CREATE SCHEMA indec;');
		DB::statement('CREATE SCHEMA indicadores;');
		DB::statement('CREATE SCHEMA logs;');
		DB::statement('CREATE SCHEMA mobile;');
		DB::statement('CREATE SCHEMA osp;');
		DB::statement('CREATE SCHEMA prestaciones;');
		DB::statement('CREATE SCHEMA profe;');
		DB::statement('CREATE SCHEMA pss;');
		DB::statement('CREATE SCHEMA puco;');
		DB::statement('CREATE SCHEMA sistema;');
		DB::statement('CREATE SCHEMA sss;');
		DB::statement('CREATE SCHEMA tmp;');
		DB::statement('CREATE SCHEMA trazadoras;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('CREATE SCHEMA beneficiarios;');
		DB::statement('CREATE SCHEMA comprobantes;');
		DB::statement('CREATE SCHEMA compromiso_anual;');
		DB::statement('CREATE SCHEMA consultas;');
		DB::statement('CREATE SCHEMA ddjj;');
		DB::statement('CREATE SCHEMA efectores;');
		DB::statement('CREATE SCHEMA fondos;');
		DB::statement('CREATE SCHEMA geo;');
		DB::statement('CREATE SCHEMA indec;');
		DB::statement('CREATE SCHEMA indicadores;');
		DB::statement('CREATE SCHEMA logs;');
		DB::statement('CREATE SCHEMA mobile;');
		DB::statement('CREATE SCHEMA osp;');
		DB::statement('CREATE SCHEMA prestaciones;');
		DB::statement('CREATE SCHEMA profe;');
		DB::statement('CREATE SCHEMA pss;');
		DB::statement('CREATE SCHEMA puco;');
		DB::statement('CREATE SCHEMA sistema;');
		DB::statement('CREATE SCHEMA sss;');
		DB::statement('CREATE SCHEMA tmp;');
		DB::statement('CREATE SCHEMA trazadoras;');
	}
}
