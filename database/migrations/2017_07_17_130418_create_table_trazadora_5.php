<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTrazadora5 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trazadoras.trz_5', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('periodo');
            $table->char('codigo_departamento', 3);
            $table->integer('denominador')->nullable();
            $table->integer('casos')->nullable();
            $table->decimal('porcentaje', 3, 2)->nullable();
            $table->integer('lote');
            $table->index(['periodo','codigo_departamento']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('trazadoras.trz_5');
    }
}
