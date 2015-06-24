<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubidasOsp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sistema.subidas_osp', function (Blueprint $table) {
            $table->integer('id_subida');
            $table->integer('codigo_osp');
            $table->integer('id_archivo');

            $table->foreign('id_subida')->references('id_subida')->on('sistema.subidas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sistema.subidas_osp');
    }
}
