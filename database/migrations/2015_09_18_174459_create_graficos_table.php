<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGraficosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('graficos.graficos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo' , 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('form')->nullable();
            $table->string('css')->nullable();

            \DB::statement(" ALTER TABLE graficos.graficos ADD COLUMN tags character varying[] ;");                         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('graficos.graficos');
    }
}
