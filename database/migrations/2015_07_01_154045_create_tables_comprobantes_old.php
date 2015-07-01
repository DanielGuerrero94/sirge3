<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesComprobantesOld extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$yaEsta = false;

		for ($i = 1; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			elseif ($i == 12 &&  ! $yaEsta)
			{
				$prov = (string) "11_bis";
				$i--;
				$yaEsta = true;
			}
			else
			{
				$prov = (string) $i;
			}

			Schema::create('comprobantes_old.c_'.$prov, function(Blueprint $table)
			{
				$table->char('cuie', 6);
				$table->date('fecha_comprobante')->nullable();
				$table->string('tipo_comprobante', 50)->nullable();
				$table->string('num_comprobante', 50)->nullable();
				$table->string('periodo', 50)->nullable();
				$table->date('fecha_recepcion')->nullable();
				$table->float('importe')->nullable();
				$table->string('expediente', 50)->nullable();
				$table->date('fecha_notificacion')->nullable();
				$table->float('importe_pagado')->nullable();
				$table->date('fecha_debito')->nullable();
				$table->date('fecha_liquidacion', 50)->nullable();
				$table->string('concepto', 200)->nullable();
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
		$yaEsta = false;

		for ($i = 1; $i <= 24; $i++)
		{
			if ($i < 10)
			{
				$prov = '0'.$i;
			}
			elseif ($i == 12 &&  ! $yaEsta)
			{
				$prov = (string) "11_bis";
				$i--;
				$yaEsta = true;
			}
			else
			{
				$prov = (string) $i;
			}
			Schema::drop('comprobantes_old.c_'.$prov);
		}
	}
}
