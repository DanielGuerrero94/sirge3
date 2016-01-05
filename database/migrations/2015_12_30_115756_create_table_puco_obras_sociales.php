<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePucoObrasSociales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puco.obras_sociales', function(Blueprint $table)
        {
            $table->increments('id_osp');
            $table->integer('codigo_osp')->unique();
            $table->string('sigla',20)->nullable();
            $table->text('nombre');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('puco.obras_sociales');
    }
}
