<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableIndicadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablero.indicadores', function (Blueprint $table) {            
            $table->string('indicador', 8)->primary();            
            $table->string('descripcion', 100)->nullable();
            $table->string('numerador', 100)->nullable();
            $table->string('denominador', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tablero.indicadores');
    }
}
