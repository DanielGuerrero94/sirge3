<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDdjjDoiu9 extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ddjj.doiu9', function(Blueprint $table)
		{
			$table->increments('id_impresion');
			$table->char('id_provincia', 2);
			$table->integer('id_usuario')->unsigned()->nullable();
			$table->char('periodo_reportado', 7);
			$table->integer('efectores_integrantes')->unsigned()->nullable();
			$table->integer('efectores_convenio')->unsigned()->nullable();
			$table->char('periodo_tablero_control', 7);
			$table->date('fecha_cuenta_capitas');
			$table->char('periodo_cuenta_capitas', 7);
			$table->date('fecha_sirge');
			$table->char('periodo_sirge', 7);
			$table->date('fecha_reporte_bimestral');
			$table->smallInteger('bimestre')->nullable();
			$table->integer('anio_bimestre')->unsigned()->nullable();
			$table->integer('version');
			$table->text('motivo_reimpresion')->nullable();
		});

		\DB::statement("ALTER TABLE ddjj.doiu9 ADD COLUMN fecha_impresion timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone;");
		\DB::statement("ALTER TABLE ddjj.doiu9 DROP CONSTRAINT doiu9_pkey;");

		Schema::table('ddjj.doiu9', function(Blueprint $table)
		{
			$table->primary(['id_provincia', 'periodo_reportado', 'version']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ddjj.doiu9');
	}
}
