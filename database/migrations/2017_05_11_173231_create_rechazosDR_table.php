<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRechazosDRTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs.rechazosDR', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('lote');
            $table->jsonb('registro');
            $table->jsonb('motivos');
            $table->nullableTimestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('logs.rechazosDR');
    }
}
