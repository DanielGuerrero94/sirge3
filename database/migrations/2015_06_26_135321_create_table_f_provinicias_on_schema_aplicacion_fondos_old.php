<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFProviniciasOnSchemaAplicacionFondosOld extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		for ($i = 0; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			else
			{
				$prov = (string) $i;
			}

			Schema::create('aplicacion_fondos_old.f_'.$prov, function(Blueprint $table)
			{
				$table->string('cuie', 6)->primary();
				$table->date('fecha_gasto');
				$table->string('periodo_rendicion', 50);
				$table->float('item_11');
				$table->float('item_12');
				$table->float('item_13');
				$table->float('item_21');
				$table->float('item_22');
				$table->float('item_23');
				$table->float('item_31');
				$table->float('item_32');
				$table->float('item_41');
				$table->float('item_42');
				$table->float('item_43');
				$table->float('item_51');
				$table->float('item_52');
				$table->float('item_53');
				$table->float('item_61');
			});

		}

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		for ($i = 0; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			else
			{
				$prov = (string) $i;
			}
			Schema::drop('aplicacion_fondos_old.f_$prov');
		}
	}
}
