<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LogRechazos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs.rechazos', function (Blueprint $table) {
            $table->increments('id')->primary();
            $table->integer('lote');
            $table->jsonb('registro');
            $table->jsonb('motivos');
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
        Schema::drop('logs.rechazos');
    }
}
