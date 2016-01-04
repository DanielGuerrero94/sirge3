<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDiccionariosDiccionario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diccionarios.diccionario', function (Blueprint $table) {
            $table->integer('padron');
            $table->integer('orden');
            $table->string('campo')->nullable();
            $table->string('tipo')->nullable();
            $table->char('obligatorio',2)->nullable();
            $table->text('descripcion')->nullable();
            $table->primary(['padron','orden']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('diccionarios.diccionario');
    }
}
