<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFondosA18 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fondos.a_18', function (Blueprint $table) {
            $table->string('efector', 14);
            $table->date('fecha_gasto');
            $table->integer('periodo');
            $table->string('numero_comprobante', 50);
            $table->tinyInteger('codigo_gasto');
            $table->tinyInteger('subcodigo_gasto');
            $table->string('efector_cesion')->nullable();
            $table->decimal('monto',10,2);
            $table->text('concepto')->nullable();
            $table->integer('lote');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('fondos.a_18');
    }
}
