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

			Schema::create('aplicacion_fondos_old.f_$prov', function(Blueprint $table)
			{
				$table->string('cuie', 6)->primary();
				$table->date('fecha_gasto');
				$table->string('periodo_rendicion', 50);
				$table->numeric('item_11');
				$table->numeric('item_12');
				$table->numeric('item_13');
				$table->numeric('item_21');
				$table->numeric('item_22');
				$table->numeric('item_23');
				$table->numeric('item_31');
				$table->numeric('item_32');
				$table->numeric('item_41');
				$table->numeric('item_42');
				$table->numeric('item_43');
				$table->numeric('item_51');
				$table->numeric('item_52');
				$table->numeric('item_53');
				$table->numeric('item_61');
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
