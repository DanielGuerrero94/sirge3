<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRangos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tablero.rangos', function (Blueprint $table) {            
            $table->integer('indicador', 8);
            $table->integer('year');            
            $table->integer('max_rojo')->nullable();
            $table->integer('min_rojo')->nullable();
            $table->integer('max_verde')->nullable();
            $table->integer('min_verde')->nullable();
            $table->primary(['indicador', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tablero.rangos');
    }
}
