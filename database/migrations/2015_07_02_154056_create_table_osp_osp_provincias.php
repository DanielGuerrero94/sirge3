<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableOspOspProvincias extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/*
		$default = (int) 901001;

		for ($i = 1; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			else
			{
				$prov = (string) $i;
			}

			Schema::create('osp.osp_'.$prov, function(Blueprint $table)
			{

				$table->string('tipo_documento', 3);
				$table->bigInteger('numero_documento')->unsigned();
				$table->string('nombre_apellido', 50);
				$table->char('sexo', 1);
				$table->string('codigo_postal', 8);
				$table->char('tipo_afiliado', 1);
				$table->foreign('tipo_documento')
				->references('tipo_documento')
				->on('sistema.tipo_documento');
			});

			if ($prov == '18')
			{
				Schema::table('osp.osp_'.$prov, function(Blueprint $table)
				{
					$table->integer('codigo_os')->unsigned()->nullable();
				});
			}
			else
			{
				\DB::statement('ALTER TABLE osp.osp_'.$prov.' ADD COLUMN codigo_os integer DEFAULT '.$default);
			}

			Schema::table('osp.osp_'.$prov, function(Blueprint $table)
			{
				$table->foreign('codigo_os')
				->references('codigo_osp')
				->on('puco.obras_sociales');
			});

			if ($prov == '01')
			{
				Schema::table('osp.osp_'.$prov, function(Blueprint $table)
				{
					$table->integer('lote')->unsigned()->nullable();
				});
			}

			$default += 1000;
		}
		*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		/*
		for ($i = 1; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			else
			{
				$prov = (string) $i;
			}
			Schema::drop('osp.osp_'.$prov);
		}
		*/
	}
}
