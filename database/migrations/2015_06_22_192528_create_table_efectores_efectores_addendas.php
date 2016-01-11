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
            $table->integer('id_efector');
            $table->integer('id_addenda');
            $table->date('fecha_addenda');
            $table->timestamps();

            $table->unique(['id_efector','id_addenda']);
            $table->foreign('id_efector')->references('id_efector')->on('efectores.efectores')->onDelete('cascade');
            $table->foreign('id_addenda')->references('id')->on('efectores.addendas')->onDelete('cascade');
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
