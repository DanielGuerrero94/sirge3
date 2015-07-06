<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDdjjBackup extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ddjj.backup', function(Blueprint $table)
		{
			$table->increments('id_impresion');
			$table->char('id_provincia', 2);
			$table->integer('id_usuario')->unsigned()->nullable();
			$table->char('periodo_reportado', 7);
			$table->date('fecha_backup');
			$table->text('nombre_backup');
			$table->integer('version')->unsigned();
			$table->text('motivo_reimpresion');
		});

		\DB::statement("ALTER TABLE ddjj.backup ADD COLUMN fecha_impresion timestamp without time zone DEFAULT ('now'::text)::timestamp without time zone;");
		\DB::statement("ALTER TABLE ddjj.backup DROP CONSTRAINT backup_pkey;");

		Schema::table('ddjj.backup', function(Blueprint $table)
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
		Schema::drop('ddjj.backup');
	}
}
