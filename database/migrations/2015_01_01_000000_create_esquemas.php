<?php

use Illuminate\Database\Migrations\Migration;

class CreateEsquemas extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('CREATE SCHEMA aplicacion_fondos_old;');
		DB::statement('CREATE SCHEMA beneficiarios;');
		DB::statement('CREATE SCHEMA comprobantes;');
		DB::statement('CREATE SCHEMA comprobantes_old;');
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
		DB::statement('CREATE SCHEMA prestaciones_old;');
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
	public function down()
	{
		DB::statement('DROP SCHEMA aplicacion_fondos_old;');
		DB::statement('DROP SCHEMA beneficiarios;');
		DB::statement('DROP SCHEMA comprobantes;');
		DB::statement('DROP SCHEMA comprobantes_old;');
		DB::statement('DROP SCHEMA compromiso_anual;');
		DB::statement('DROP SCHEMA consultas;');
		DB::statement('DROP SCHEMA ddjj;');
		DB::statement('DROP SCHEMA efectores;');
		DB::statement('DROP SCHEMA fondos;');
		DB::statement('DROP SCHEMA geo;');
		DB::statement('DROP SCHEMA indec;');
		DB::statement('DROP SCHEMA indicadores;');
		DB::statement('DROP SCHEMA logs;');
		DB::statement('DROP SCHEMA mobile;');
		DB::statement('DROP SCHEMA osp;');
		DB::statement('DROP SCHEMA prestaciones;');
		DB::statement('DROP SCHEMA prestaciones_old;');
		DB::statement('DROP SCHEMA profe;');
		DB::statement('DROP SCHEMA pss;');
		DB::statement('DROP SCHEMA puco;');
		DB::statement('DROP SCHEMA sistema;');
		DB::statement('DROP SCHEMA sss;');
		DB::statement('DROP SCHEMA tmp;');
		DB::statement('DROP SCHEMA trazadoras;');
	}
}
