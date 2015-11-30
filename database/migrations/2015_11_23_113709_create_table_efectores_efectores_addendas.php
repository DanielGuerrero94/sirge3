<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEfectoresEfectoresAddendas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('efectores.efectores_addendas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_efector')->nullable();          
            $table->integer('id_addenda')->nullable();
            $table->date('fecha_addenda')->nullable();
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
        Schema::drop('efectores.efectores_addendas');
    }
}
