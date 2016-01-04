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
		DB::statement('CREATE SCHEMA indicadores;');
		DB::statement('CREATE SCHEMA logs;');
		DB::statement('CREATE SCHEMA mobile;');
		DB::statement('CREATE SCHEMA prestaciones;');
		DB::statement('CREATE SCHEMA pss;');
		DB::statement('CREATE SCHEMA puco;');
		DB::statement('CREATE SCHEMA sistema;');					
		DB::statement('CREATE SCHEMA solicitudes;');
		DB::statement('CREATE SCHEMA graficos;');
		DB::statement('CREATE SCHEMA chat;');
		DB::statement('CREATE SCHEMA diccionarios;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		DB::statement('DROP SCHEMA beneficiarios CASCADE;');
		DB::statement('DROP SCHEMA comprobantes CASCADE;');
		DB::statement('DROP SCHEMA compromiso_anual  CASCADE;');
		DB::statement('DROP SCHEMA consultas CASCADE;');
		DB::statement('DROP SCHEMA ddjj CASCADE;');
		DB::statement('DROP SCHEMA efectores CASCADE;');
		DB::statement('DROP SCHEMA fondos CASCADE;');
		DB::statement('DROP SCHEMA geo CASCADE;');
		DB::statement('DROP SCHEMA indicadores CASCADE;');
		DB::statement('DROP SCHEMA logs CASCADE;');
		DB::statement('DROP SCHEMA mobile CASCADE;');
		DB::statement('DROP SCHEMA prestaciones CASCADE;');
		DB::statement('DROP SCHEMA pss CASCADE;');
		DB::statement('DROP SCHEMA puco CASCADE;');
		DB::statement('DROP SCHEMA sistema CASCADE;');				
		DB::statement('DROP SCHEMA solicitudes CASCADE;');
		DB::statement('DROP SCHEMA graficos CASCADE;');
		DB::statement('DROP SCHEMA chat CASCADE;');
		DB::statement('DROP SCHEMA diccionarios CASCADE;');

	}
}
