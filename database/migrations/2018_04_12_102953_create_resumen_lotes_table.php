<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumenLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dr.resumen_lotes', function (Blueprint $table) {
            $table->integer('lote');
            $table->integer('validos');
            $table->integer('ausentes');
            $table->integer('errores');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dr.resumen_lotes');
    }
}
